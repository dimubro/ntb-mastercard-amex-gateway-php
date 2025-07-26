<?php
$recipt_number = $_GET['ReceiptNo'];
if($recipt_number){
            $resultIndicator = $_GET['resultIndicator'];
            // $order = get your order details to that array using recipt number. we want get result indicatoir from db when we updated on payment gateway request.
            if($order->SuccessIndicator==$resultIndicator){
                // paiment success
            }else{
                
                //redirect paiment fail
            }
        }

?>