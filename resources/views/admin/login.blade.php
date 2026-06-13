<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Admin Login – Green Wheel EV</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:#09090f">
<div style="background:#fff;border-radius:18px;padding:40px;width:100%;max-width:400px;box-shadow:0 8px 40px rgba(0,0,0,.15)">
  <div style="text-align:center;margin-bottom:28px">
    <div style="width:52px;height:52px;background:linear-gradient(135deg,#00a651,#007a3d);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 12px"><i class="fas fa-bolt"></i></div>
    <h2 style="font-size:22px;font-weight:700">Admin Login</h2>
    <p style="color:#999;font-size:13px">Green Wheel EV Management</p>
  </div>
  @if($errors->any())<div style="background:#fee2e2;color:#dc2626;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px">{{ $errors->first() }}</div>@endif
  @if(session('error'))<div style="background:#fee2e2;color:#dc2626;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px">{{ session('error') }}</div>@endif
  <form method="POST" action="{{ route('admin.login.post') }}">
    @csrf
    <div style="margin-bottom:16px"><label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px">Email</label><input type="email" name="email" required value="{{ old('email') }}" style="width:100%;padding:11px 14px;border:1.5px solid #e0e0e0;border-radius:9px;font-family:'Poppins',sans-serif;font-size:13.5px" placeholder="admin@greenwheelev.com"></div>
    <div style="margin-bottom:20px"><label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px">Password</label><input type="password" name="password" required style="width:100%;padding:11px 14px;border:1.5px solid #e0e0e0;border-radius:9px;font-family:'Poppins',sans-serif;font-size:13.5px" placeholder="••••••••"></div>
    <button type="submit" style="width:100%;background:linear-gradient(135deg,#00a651,#007a3d);color:#fff;border:none;padding:13px;border-radius:10px;font-family:'Poppins',sans-serif;font-size:14px;font-weight:600;cursor:pointer">Login to Admin Panel</button>
  </form>
  <div style="text-align:center;margin-top:16px"><a href="{{ route('home') }}" style="color:#999;font-size:12.5px;text-decoration:none"><i class="fas fa-arrow-left"></i> Back to website</a></div>
</div>
</body>
</html>
