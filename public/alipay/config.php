<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2021001163632546",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAn05ZLmjt9C8H5j5+FWAK4M0dVGJC1YXb2FLaRAIa7k1AJhrWmOMgMxnycqOP5sJHMTKR2rOEab97g1+9aSlEBNjJE4vPJoWxTJ8L+4RgQM9/KVjkK/1CbyCbgj49ow33YtkYU82Syb3/crrytWSkmV7rTMmLNt8DVFiyU4uL5pebl+xUgU1tLlgJVlue8QnBOIaHEnIT7MXQYiSAKQjXXXAGxMWOmyX2F9tfNpP0mXo9bi6VaaMKSXa6kwh3/Rrywzi4ntt0DY59AD+yg0lk1YxN03+nwdRJwnGG7JFtLtijCpoY0iuhmRR4cg55u0bcj+AMHRshy0cGLSJQU3IJaQIDAQAB",
		
		//异步通知地址
		'notify_url' => "http://工程公网访问地址/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://mitsein.com/alipay.trade.wap.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAn6tfG6ArVmaoKGnA6hRiBGFYD2EAIPeE3zPatCsbtYI1C2HRA2iZLWakMrr7E8iUWNtm4vZ2EKsUSyKAk2wDYFYz3A2Lm8c6nkQ1bplxdsZF7uBi3+5B0t3pz2nl5M7yjzTm2u/rNqjEcDRW6N1UBvv1Fz1x7ESFVvqUJZvAuS0OlL7gr80fMk4/BM2BK0knfzITkVc9n0NFUeNgmfXJM522t27LVTeH1S48vBUfmLl3L8VcP5plSL+yJXmb/GHDT9XPljfEC3WzTJDrycNnLaUebrFj82SMG0yK9+lhoryzHYTiFszx72gdkXA5LyU1DKpXlYCyglmTu3uTjojczQIDAQAB",
		
	
);