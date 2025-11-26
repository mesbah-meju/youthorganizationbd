<?php

namespace App\Utility;

use App\Models\ProductStock;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class ScheduleUtility
{
    public static function student_search($request_data): object
    {
        $school_id = Session::get('school_id');

        $students = Student::where('school_id', $school_id)
            ->where('is_current_school', 1)
            ->orderBy('id', 'asc');

        if ($request_data['campus_id'] != null) {
            $students = $students->where('students.campus_id', $request_data['campus_id']);
        }

        if ($request_data['shift_id'] != null) {
            $students = $students->where('students.shift_id', $request_data['shift_id']);
        }

        if ($request_data['class_id'] != null) {
            $students = $students->where('students.class_id', $request_data['class_id']);
        }

        if ($request_data['section_id'] != null) {
            $students = $students->where('students.section_id', $request_data['section_id']);
        }

        if ($request_data['keyword'] != null) {
            $students = $students->whereHas('user', function ($query) use ($request_data) {
                $query->where('name', 'like', '%' . $request_data['keyword'] . '%');
            });
        }

        // Exclude students who are already in schedule_details
        $students = $students->whereNotIn('students.user_id', function ($query) {
            $query->select('student_id')
                ->from('schedule_details');
        });

        return $students->paginate(16);
    }  


    public static function student_search_admin($request_data): object
    {
        // dd($request_data);
       $school_id = $request_data['school_id'] ?? Session::get('school_id');

        $students = Student::where('school_id', $school_id)
            ->where('is_current_school', 1)
            ->orderBy('id', 'asc');

        if ($request_data['campus_id'] != null) {
            $students = $students->where('students.campus_id', $request_data['campus_id']);
        }

        if ($request_data['shift_id'] != null) {
            $students = $students->where('students.shift_id', $request_data['shift_id']);
        }

        if ($request_data['class_id'] != null) {
            $students = $students->where('students.class_id', $request_data['class_id']);
        }

        if ($request_data['section_id'] != null) {
            $students = $students->where('students.section_id', $request_data['section_id']);
        }

        if ($request_data['keyword'] != null) {
            $students = $students->whereHas('user', function ($query) use ($request_data) {
                $query->where('name', 'like', '%' . $request_data['keyword'] . '%');
            });
        }

        // Exclude students who are already in schedule_details
        $students = $students->whereNotIn('students.user_id', function ($query) {
            $query->select('student_id')
                ->from('schedule_details');
        });

        return $students->paginate(16);
    }  

    public static function orderStore($data)
    {
        $shippingInfo = $data['shippingInfo'];
        if ($shippingInfo == null || $shippingInfo['name'] == null || $shippingInfo['phone'] == null || $shippingInfo['address'] == null) {
            return array('success' => 0, 'message' => translate("Please Add Shipping Information."));
        } else {
            $carts = get_pos_user_cart($data['user_id'], $data['temp_usder_id']);
            if (count($carts) > 0) {
                $order = new Order();
                $userId = $data['user_id'];
                if ($userId == null) {
                    $order->guest_id  = $carts[0]->temp_user_id;
                } else {
                    $order->user_id = $userId;
                }
                $order->shipping_address = json_encode($shippingInfo);

                $order->payment_type    = $data['payment_type'];
                $order->delivery_viewed = '0';
                $order->payment_status_viewed = '0';
                $order->code            = date('Ymd-His') . rand(10, 99);
                $order->date            = strtotime('now');
                $order->payment_status  = $data['payment_type'] != 'cash_on_delivery' ? 'paid' : 'unpaid';
                $order->payment_details = $data['payment_type'];
                $order->order_from      = 'pos';

                if ($data['payment_type'] == 'offline_payment') {
                    if ($data['offline_trx_id'] == null) {
                        return array('success' => 0, 'message' => translate("Transaction ID cannot be null."));
                    }
                    $data['name']   = $data['offline_payment_method'];
                    $data['amount'] = $data['offline_payment_amount'];
                    $data['trx_id'] = $data['offline_trx_id'];
                    $data['photo']  = $data['offline_payment_proof'];
                    $order->manual_payment_data = json_encode($data);
                    $order->manual_payment = 1;
                }

                if ($order->save()) {
                    $subtotal = 0;
                    $tax = 0;
                    foreach ($carts as $key => $cartItem) {
                        $product_stock      = $cartItem->product->stocks->where('variant', $cartItem['variation'])->first();
                        $product            = $product_stock->product;
                        $product_variation  = $product_stock->variant;

                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                        $tax += $cartItem['tax'] * $cartItem['quantity'];

                        if ($product->digital == 0) {
                            if ($cartItem['quantity'] > $product_stock->qty) {
                                $order->delete();
                                return array('success' => 0, 'message' => $product->name . ' (' . $product_variation . ') ' . translate(" just stock outs."));
                            } else {
                                $product_stock->qty -= $cartItem['quantity'];
                                $product_stock->save();
                            }
                        }

                        $order_detail                   = new OrderDetail;
                        $order_detail->order_id         = $order->id;
                        $order_detail->seller_id        = $product->user_id;
                        $order_detail->product_id       = $product->id;
                        $order_detail->payment_status   = $data['payment_type'] != 'cash_on_delivery' ? 'paid' : 'unpaid';
                        $order_detail->variation        = $product_variation;
                        $order_detail->price            = $cartItem['price'] * $cartItem['quantity'];
                        $order_detail->tax              = $cartItem['tax'] * $cartItem['quantity'];
                        $order_detail->quantity         = $cartItem['quantity'];
                        $order_detail->shipping_type    = null;

                        if ($data['shippingCost'] >= 0) {
                            $order_detail->shipping_cost = $data['shippingCost'] / count($carts);
                        } else {
                            $order_detail->shipping_cost = 0;
                        }

                        $order_detail->save();

                        $product->num_of_sale++;
                        $product->save();
                    }

                    $order->grand_total = $subtotal + $tax + $data['shippingCost'];

                    if ($data['discount']) {
                        $order->grand_total -= $data['discount'];
                        $order->coupon_discount = $data['discount'];
                    }

                    $order->seller_id = $product->user_id;
                    $order->save();

                    $array['view']      = 'emails.invoice';
                    $array['subject']   = 'Your order has been placed - ' . $order->code;
                    $array['from']      = env('MAIL_USERNAME');
                    $array['order']     = $order;

                    $admin_products = array();
                    $seller_products = array();

                    foreach ($order->orderDetails as $key => $orderDetail) {
                        if ($orderDetail->product->added_by == 'admin') {
                            array_push($admin_products, $orderDetail->product->id);
                        } else {
                            $product_ids = array();
                            if (array_key_exists($orderDetail->product->user_id, $seller_products)) {
                                $product_ids = $seller_products[$orderDetail->product->user_id];
                            }
                            array_push($product_ids, $orderDetail->product->id);
                            $seller_products[$orderDetail->product->user_id] = $product_ids;
                        }
                    }

                    foreach ($seller_products as $key => $seller_product) {
                        try {
                            Mail::to(User::find($key)->email)->queue(new InvoiceEmailManager($array));
                        } catch (\Exception $e) {
                        }
                    }

                    //sends email to customer with the invoice pdf attached
                    if (env('MAIL_USERNAME') != null) {
                        try {
                            Mail::to($shippingInfo['email'])->queue(new InvoiceEmailManager($array));
                            Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                        } catch (\Exception $e) {
                        }
                    }

                    if ($userId != NULL && $order->payment_status == 'paid') {
                        calculateCommissionAffilationClubPoint($order);
                    }

                    Cart::where('user_id', $order->user_id)->orWhere('temp_user_id', $order->guest_id)->delete();

                    return array('success' => 1, 'message' => translate('Order Completed Successfully.'));
                } else {
                    return array('success' => 0, 'message' => translate('Please input customer information.'));
                }
            }
            return array('success' => 0, 'message' => translate("Please select a product."));
        }
    }
}
