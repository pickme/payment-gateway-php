<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Payment Form</title>
        <script type="text/javascript">
            String.prototype.isNumber = function() {
                return /^\d+$/.test(this);
            }
        </script>
    </head>
    <body>
        <h1>Sample payment form</h1>
 
        <form action="./?route=Root/process" method="POST" id="payment-form">
            <span class="payment-errors">
            <?php if( isset($ErrMsg) ) { ?>
            <font color="red"><?php echo $ErrMsg ?></font>
            </span>
            <?php  } else if (isset($Message)) { ?>
            <font color="blue"><?php echo $Message ?></font>
            </span>
             <?php }?>
            <h2>Customer section</h2>
            <div class="form-row">
                <label>
                    <span>Customer name</span>
                    <input name ="customer" id="customer" type="text" size="50" />
                </label>
            </div>

            <h2>Amount section</h2>
            <div class="form-row">
                <label>
                    <span>Price</span>
                    <input name="total" id="total" type="text" size="15" />
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
                    <input name="holder" id="holder" type="text" size="50" />
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
                    <input name="number" id="number" type="text" size="20"/>
                </label>
            </div>
 
            <div class="form-row">
                <label>
                    <span>CVC</span>
                    <input name="cvc" id="cvc" type="text" size="4"/>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Expiration (MM/YY)</span>
                    <select name="mm">
                        <option value="01">1</option>
                        <option value="02">2</option>
                        <option value="03">3</option>
                        <option value="04">4</option>
                        <option value="05">5</option>
                        <option value="06">6</option>
                        <option value="07">7</option>
                        <option value="08">8</option>
                        <option value="09">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </label>
                <span> / </span>
                <select name="yy">
                        <option value="12">2012</option>
                        <option value="13">2013</option>
                        <option value="14">2014</option>
                        <option value="15">2015</option>
                        <option value="16">2016</option>
               </select>
            </div>
            <br>
            <button type="submit">Submit Payment</button>
        </form>
        <script type="text/javascript">
             document.getElementById("payment-form").onsubmit = function() {
                 var customer = document.getElementById("customer").value;
                 if( customer == '' ) {
                     alert("Please input customer name");
                     return false;
                 }
                 var total = document.getElementById("total").value;
                 if( (total == '') || ( total.isNumber() == false ) ){
                     alert("Please input price as number");
                     return false;
                 }
                 var holder = document.getElementById("holder").value;
                 if( holder == '' ) {
                     alert("Please input card holder name");
                     return false;
                 }
                 var numb = document.getElementById("number").value;
                 if( ( numb == '') || ( numb.isNumber() == false ) || ( numb.length < 15) ) {
                     alert("Please input correct card number");
                     return false;
                 }
                 var cvc = document.getElementById("cvc").value;
                 if( ( cvc == '') || ( cvc.isNumber() == false ) ) {
                     alert("Please input correct cvc number");
                     return false;
                 }
                 return true;
             };
        </script>
    </body>
</html> 