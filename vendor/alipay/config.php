<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2021001163632546",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEA3qccZCWrOXS7nYn1DsGOb5pLIG/KU4d6Cm6wM164n5bT33fkTiqUlBoKm4YvEyPTWyZbAz0lhD7hcklYIHTvZJRJn5t71ei0la66ej8b250r8/miUHtc7leJG2N0o1qUpCnuDtodNLw5IaKp9I+5Hmn3apAZgQoe3sUe0EnyXk76T5i2/zRgtmr0WXcARvDqalje8XdkKm+E3hOwEBz8dYLYJSg5bXMOMbmwR5riE7+gnOq/Awiyk86pDWQg2m1MRofQALAhLZySj8/tbAfgAvjFM3FXiOlp4e4CV+mmZO54foOwmF6b9sA1VRRe7tWoc8E/oxSZMK043miennZRfwIDAQABAoIBAQDBfkTEG6BTzEiHvi6DZl5cSqBjTgNs192NV2g1HGoh9remCtETxRleI8t4IQKkBYxWOFz70ZXa+bJ+2ZKGkljA9cWNuVfDK/pT4ocYWePh1RMvcZBHlQ3L67KxZJsmoz9t8yp5KcAb5j9YJb7BVG2yKrDjoNspMxxkyLXgmYLRxP2X+yVI7yeir4WGPsSQDGjrttmpWPGDaRhMnaPaLIL2G1a4NMVwJozKzCzuEyaiASfzwSGt4Nnqyp2pmisz5Nf9lh2GfK5K1L5Y2kpexkfQ3Ou8xTLZKtdCydx2LXmf7a2PMIvLUrgOBOhIx4pRXbQjeKVgVZVtM/3Zpm/WnjEBAoGBAPkr6bcv2sGKNuFzVPXgVHh6YwzHG0OUxbEQ6vXXjkgnc7j/aYY0WESk7aUD5SXXTq0Gr7kj/C39t5X6P2Qj8tWvTU9O3fxD8u6DOYaX78IqJDyRO7y6QKWWYI0Xdp0tPoWMRQpzQYraj/glQ+FiHhPeUKMMc6606yXOrOdxarg/AoGBAOTBJy1QxeHeOLGPNcvfq9J1lZbCtK5ZzFTHMLCxUtYzzHx4v8xmK4yDRcitNCwihA4KGmJDU6U6wuJCeZ+V+vjANk76ktyzWeWTtYAl0RYTIliRKSNAXxpow5s9+juwPhHUvXHHzpkzuBuu+9DfCSoM5o/WKd3EuKFqRr5j1BbBAoGBALHN4jM0VNfy9wKeOCxUbjKisve1RQFOsluOBPx1WzSl4nBK4lRAGhSx1FsCkowUPjI+KTrmMNfoyw6cyot9E5XkSDilwMZ4/muw/GXNGevmAoGt6YDdL7B5xGAqNBwo4wqNc97nLAgXutCKVwwH5gqrg8M16X7r3zjVaJCnYE4lAoGABm7UHjceSXrJV1zyo1gX6eQ6n7G8CQcnct7jJKTn8nQkdP+kTSg2Y04xwTH1vKP/2LE6Crdf+86KOniqGO3L0AD/xfrP9HrqtUURHphxp9BD7/+tC3u88O4vSgdVKSaMqE22QiPfUHme3NBv7nDHPjJ8rWDVbpIgqxFlCeeeyEECgYBXybTNYFFUR4SyN2+EMW8YfO1mrhzMy6fq4/ZEavltmzaYQ2yastZL5k4vLc+TDYb+BY+UiOO7ODmTXgd8WfKs5RcNAScIMscORDUAskLEVEPnoF5MuYgKJZhGXSD1ePUV83Mvwr8W/PJvX/469W37kyGFB1rKfTKsjeVrmFwKzQ==",
		
		//异步通知地址
		'notify_url' => "https://yzpaopao.com/pay/notify_url",
		
		//同步跳转
		'return_url' => "https://yzpaopao.com/pay/return_url",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAn6tfG6ArVmaoKGnA6hRiBGFYD2EAIPeE3zPatCsbtYI1C2HRA2iZLWakMrr7E8iUWNtm4vZ2EKsUSyKAk2wDYFYz3A2Lm8c6nkQ1bplxdsZF7uBi3+5B0t3pz2nl5M7yjzTm2u/rNqjEcDRW6N1UBvv1Fz1x7ESFVvqUJZvAuS0OlL7gr80fMk4/BM2BK0knfzITkVc9n0NFUeNgmfXJM522t27LVTeH1S48vBUfmLl3L8VcP5plSL+yJXmb/GHDT9XPljfEC3WzTJDrycNnLaUebrFj82SMG0yK9+lhoryzHYTiFszx72gdkXA5LyU1DKpXlYCyglmTu3uTjojczQIDAQAB",

);