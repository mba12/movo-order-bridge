<?php        namespace Movo\Orders;


use Coupon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Movo\Handlers\OrderHandler;
use Movo\Handlers\PusherHandler;
use Movo\Handlers\ReceiptHandler;
use Movo\Handlers\ShippingHandler;
use Movo\Observer\Subject;
use Order;
use Product;
use Shipping;

class ProcessOrder implements Subject
{

    public function process()
    {
        $billing = App::make('Movo\Billing\BillingInterface');
        $salesTax = App::make('Movo\SalesTax\SalesTaxInterface');
        $couponInstance = Coupon::getValidCouponInstance();


        $salesTaxRate = $salesTax->getRate(Input::get("shipping-zip"), Input::get("shipping-state"));
        if (!isset($salesTaxRate)) {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order. Your state and zip code do not match'));
        }


        $unitPrice = Product::getUnitPrice();
        $shippingMethod = Shipping::getShippingMethod(Input::get("shipping-type"));
        $discount = $couponInstance ? $couponInstance->calculateCouponDiscount($unitPrice, Input::get("quantity")) : 0;

        $result = $billing->charge([
            'token' => Input::get("token"),
            'amount' => $this->getOrderTotal($unitPrice, Input::get("quantity"), $discount, $shippingMethod, $salesTaxRate, Input::get("shipping-state")),
            'email' => Input::get("email")
        ]);

        if ($result) {
            $this->attach([
                new ReceiptHandler(),
                new ShippingHandler(),
                new PusherHandler(),
                new OrderHandler()
            ]);
            $data = [
                'result' => $result,
                'unit-price' => $unitPrice,
                'couponInstance' => $couponInstance,
                'shipping-rate' => $shippingMethod->rate,
                'shipping-type' => $shippingMethod->type,
            ];
            $this->notify($data);
            return Response::json(array('status' => '200', 'message' => 'Your order has been submitted!'));

        } else {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order'));

        }
    }

    private function getOrderTotal($unitPrice, $quantity, $discount, $shippingMethod, $salesTaxRate, $state)
    {
        $orderTotal = CalculateOrderTotal::calculateTotal([
            "quantity" => $quantity,
            "tax-rate" => $salesTaxRate,
            "unit-price" => $unitPrice,
            "state" => $state,
            "shipping-rate" => $shippingMethod->rate,
            "discount" => $discount,
        ]);
        return $orderTotal;
    }

    protected $observers = [];

    public function attach($observable)
    {
        if (is_array($observable)) {
            foreach ($observable as $observer) {
                $this->attach($observer);
                return;
            }
        }
        $this->observers[] = $observable;
    }

    public function detach($index)
    {
        unset($this->observers[$index]);
    }

    public function notify($data)
    {
        foreach ($this->observers as $observer) {
            $observer->handleNotification($data);
        }
    }
}