<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Complete Profile</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #f8f8f8; font-family: 'Roboto', sans-serif; font-size: 15px; }
    .page { width: 100%; min-height: 100vh; background: #f8f8f8; padding: 60px 15px 30px; }
    .header { width: 100%; max-width: 991px; height: 50px; padding: 0 15px; background: #3244a8; text-align: center; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; display: flex; align-items: center; justify-content: center; }
    .header .back-btn { width: 30px; height: 30px; position: absolute; left: 15px; top: 10px; cursor: pointer; }
    .header .back-btn i { color: #fff; font-size: 24px; }
    .header span { font-size: 18px; font-weight: 500; color: #fff; }

    .profile-card { width: 100%; background: #fff; border-radius: 10px; padding: 25px 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .profile-card .title { font-size: 18px; font-weight: 700; color: #151515; margin-bottom: 20px; padding-left: 15px; position: relative; }
    .profile-card .title::before { content: ''; width: 5px; height: 25px; background: #ffa200; border-radius: 4px; position: absolute; left: 0; top: -2px; }
    
    .form-group { margin-bottom: 20px; }
    .form-group label { font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px; display: block; }
    .form-group label .required { color: #ff0000; margin-left: 3px; }
    .form-control { width: 100%; height: 45px; padding: 0 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; color: #333; }
    .form-control:focus { border-color: #3244a8; outline: none; box-shadow: 0 0 0 3px rgba(50,68,168,0.1); }
    .form-control:disabled { background: #f5f5f5; color: #999; }
    
    .profile-upload { text-align: center; margin-bottom: 25px; }
    .profile-upload .image-preview { width: 120px; height: 120px; border-radius: 50%; margin: 0 auto 15px; border: 3px solid #3244a8; overflow: hidden; position: relative; }
    .profile-upload .image-preview img { width: 100%; height: 100%; object-fit: cover; }
    .profile-upload .upload-btn { display: inline-block; padding: 10px 25px; background: #ffa200; color: #fff; border-radius: 25px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s; }
    .profile-upload .upload-btn:hover { background: #ff8c00; }
    .profile-upload input[type="file"] { display: none; }
    
    .submit-btn { width: 100%; height: 50px; background: linear-gradient(90deg, #3244a8, #5068d6); color: #fff; border: none; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-top: 10px; }
    .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(50,68,168,0.3); }
    
    .divider { height: 1px; background: #eee; margin: 30px 0; }
    
    .input-group { position: relative; }
    .input-group .input-group-text { position: absolute; right: 0; top: 0; height: 45px; padding: 0 15px; background: transparent; border: none; display: flex; align-items: center; }
</style>
</head>

<body>
    <div class="header">
        <a href="{{ route('user.profile.setting') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span>Complete Profile</span>
    </div>

    <div class="page">
        <!-- Profile Update Form -->
        <div class="profile-card">
            <div class="title">Profile Information</div>
            
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Profile Picture Upload -->
                <div class="profile-upload">
                    <div class="image-preview">
                        <img id="profilePreview" src="{{ getImage(getFilePath('userProfile').'/'. @$user->image, getFileSize('userProfile')) }}" alt="Profile">
                    </div>
                    <label for="profileImage" class="upload-btn">
                        <i class="fas fa-camera"></i> Upload Profile Picture
                    </label>
                    <input type="file" id="profileImage" name="image" accept="image/*">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name <span class="required">*</span></label>
                            <input type="text" name="firstname" class="form-control" value="{{ old('firstname', @$user->firstname) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name <span class="required">*</span></label>
                            <input type="text" name="lastname" class="form-control" value="{{ old('lastname', @$user->lastname) }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                    <small class="text-muted">Email cannot be changed</small>
                </div>

                <div class="form-group">
                    <label>Mobile Number <span class="required">*</span></label>
                    <input type="tel" name="mobile" class="form-control" value="{{ old('mobile', @$user->mobile) }}" placeholder="+234 123 456 7890" required>
                </div>

                <div class="form-group">
                    <label>Address <span class="required">*</span></label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', @$user->address->address ?? '') }}" placeholder="Street Address" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>City <span class="required">*</span></label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', @$user->address->city ?? '') }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>State <span class="required">*</span></label>
                            <input type="text" name="state" class="form-control" value="{{ old('state', @$user->address->state ?? '') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Zip/Postal Code <span class="required">*</span></label>
                            <input type="text" name="zip" class="form-control" value="{{ old('zip', @$user->address->zip ?? '') }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Country <span class="required">*</span></label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', @$user->address->country ?? 'Nigeria') }}" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Save Profile
                </button>
            </form>
        </div>

        <!-- Change Password Section -->
        <div class="profile-card">
            <div class="title">Change Password</div>
            
            <form action="{{ route('user.password.update') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Current Password <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="password" name="current_password" class="form-control" id="currentPassword" required>
                        <span class="input-group-text" onclick="togglePassword('currentPassword')">
                            <i class="fas fa-eye" id="currentPasswordIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label>New Password <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="newPassword" required>
                        <span class="input-group-text" onclick="togglePassword('newPassword')">
                            <i class="fas fa-eye" id="newPasswordIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm New Password <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" required>
                        <span class="input-group-text" onclick="togglePassword('confirmPassword')">
                            <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-key"></i> Change Password
                </button>
            </form>
        </div>
    </div>

    @include('partials.notify')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Profile Image Preview
        document.getElementById('profileImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Toggle Password Visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + 'Icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
