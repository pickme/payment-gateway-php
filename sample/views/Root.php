<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Payment Form</title>
    </head>
    <body>
        <h1>Sample payment form</h1>
 
        <form action="./?route=Root/process" method="POST" id="payment-form">
            <span class="payment-errors"></span>

            <h2>Customer section</h2>
            <div class="form-row">
                <label>
                    <span>Customer name</span>
                    <input name ="customer" type="text" size="50" />
                </label>
            </div>

            <h2>Amount section</h2>
            <div class="form-row">
                <label>
                    <span>Price</span>
                    <input name="total" type="text" size="15" />
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Currency</span>
                    <select name="currency">
                        <option>USD</option>
                        <option>EUR</option>
                        <option>THB</option>
                        <option>HKD</option>
                        <option>SGD</option>
                        <option>AUD</option>
                    </select>
                </label>
            </div>

            <h2>Credit card section</h2>
            <div class="form-row">
                <label>
                    <span>Holder name</span>
                    <input name="holder" type="text" size="50" />
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Type</span>
                    <select name="card_type">
                        <option value="visa">Visa</option>
                        <option value="amex">AMEX</option>
                        <option value="jcb">JCB</option>
                        <option value="mastercard">MasterCard</option>
                        <option value="maestro">Maestro</option>
                        <option value="switch">Switc</option>
                    </select>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Card Number</span>
                    <input name="number" type="text" size="20"/>
                </label>
            </div>
 
            <div class="form-row">
                <label>
                    <span>CVC</span>
                    <input name="cvc" type="text" size="4"/>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Expiration (MM/YYYY)</span>
                    <input name="mm"type="text" size="2" />
                </label>
                <span> / </span>
                <input name="yyyy" type="text" size="4"/>
            </div>
            </br>
            <button type="submit">Submit Payment</button>
        </form>
    </body>
</html> 