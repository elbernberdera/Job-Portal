<style>
.sidebar-gradient-bg {
  background: linear-gradient(135deg,rgb(6, 10, 204),rgb(114, 143, 239)), url("{{ asset('assets/static/image/image2.png') }}");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
  .active-custom {
    background: #fff !important;
    color: #007bff !important;
  }
  .active-custom .nav-icon {
    color: #007bff !important;
  }
  
  .dropdown-item:hover, .dropdown-item:focus {
    color: #007bff !important;
    background-color: #f8f9fa !important;
  }

  #webcamVideo, #webcamCanvas {
    border-radius: 50% !important;
    object-fit: cover;
  }
</style>

<aside class="main-sidebar sidebar-dark-success elevation-4 sidebar-gradient-bg">
      <!-- Brand Logo -->
      <!-- <a href="{{ route('admin.dashboard') }}" class="brand-link" style="display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('assets/static/image/image3.png') }}"
             alt="Logo"
             style="width: 110px; height: 80px; " />
      </a> -->

       <!-- Sidebar -->
    <div class="sidebar" style="color: #000!important;">
    <div class="user-panel mt-4 pb-4 mb-4 d-flex flex-column align-items-center">
            <div class="position-relative" style="width: 120px; height: 120px;">
                <img
                    src="{{ Auth::user()->profile_image ? asset('profile_images/' . Auth::user()->profile_image) . '?v=' . time() : asset('assets/images/image7.png') }}"
                    alt=""
                    class="rounded-circle"
                    style="width: 100%; height: 100%; object-fit: cover; border: 4px solid #fff;"
                >
                <form id="profileImageForm" action="{{ route('hr.profile.upload') }}" method="POST" enctype="multipart/form-data" style="position: absolute; bottom: 0; right: 0;">
                    @csrf
                    <div class="dropdown">
                        <span style="background: #1abc9c; border-radius: 50%; padding: 8px; cursor:pointer;" data-bs-toggle="dropdown">
                            <i class="fa fa-camera" style="color: #fff;"></i>
                        </span>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#" onclick="handleTakePictureClick(); return false;">
                                    <i class="fa fa-camera"></i> Take a Picture
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="document.getElementById('profileImageInputFile').click(); return false;">
                                    <i class="fa fa-folder-open"></i> Choose from Files
                                </a>
                            </li>
                        </ul>
                    </div>
                    <input type="file" id="profileImageInputCamera" name="profile_image" accept="image/*" capture="user" style="display: none;" onchange="document.getElementById('profileImageForm').submit();">
                    <input type="file" id="profileImageInputFile" name="profile_image" accept="image/*" style="display: none;" onchange="if(this.files.length){document.getElementById('profileImageForm').submit();}">
                </form>
            </div>
            <div class="info mt-2">
                <a href="" class="d-block" style="color: #fbf8f8!important; font-weight: bold; text-decoration: none; text-transform: capitalize;">
                    {{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
              <a href="{{ route('hr.dashboard') }}"
                 class="nav-link {{ request()->routeIs('hr.dashboard') ? 'active-custom' : '' }}"
                 style="{{ request()->routeIs('hr.dashboard') ? 'background: #fff; color: #007bff !important;' : 'color: #fdfafa!important;' }}">
                <i class="nav-icon fas fa-home" style="{{ request()->routeIs('hr.dashboard') ? 'color: #007bff !important;' : 'color: #fbf8f8!important;' }}"></i>
                <p>Home</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('job_vacancies') }}"
                 class="nav-link {{ request()->routeIs('job_vacancies') ? 'active-custom' : '' }}"
                 style="{{ request()->routeIs('job_vacancies') ? 'background: #fff; color: #007bff !important;' : 'color: #fdfafa!important;' }}">
                <i class="nav-icon fas fa-users" style="{{ request()->routeIs('job_vacancies') ? 'color: #007bff !important;' : 'color: #fbf8f8!important;' }}"></i>
                <p>Job Vacancies</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('hr.qualified-applicants') }}"
                 class="nav-link {{ request()->routeIs('hr.qualified-applicants') ? 'active-custom' : '' }}"
                 style="{{ request()->routeIs('hr.qualified-applicants') ? 'background: #fff; color: #007bff !important;' : 'color: #fdfafa!important;' }}">
                <i class="nav-icon fas fa-user-check" style="{{ request()->routeIs('hr.qualified-applicants') ? 'color: #007bff !important;' : 'color: #fbf8f8!important;' }}"></i>
                <p>Qualified Applicants</p>
              </a>
            </li>


                <!-- Add more nav-items here as needed -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
      <!-- /.sidebar -->
    </aside>

<!-- Webcam Capture Modal -->
<div class="modal fade" id="webcamModal" tabindex="-1" aria-labelledby="webcamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="webcamModalLabel">Take a Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="stopWebcam()"></button>
      </div>
      <div class="modal-body text-center">
        <video id="webcamVideo" width="320" height="320" autoplay style="border-radius: 50%; object-fit: cover;"></video>
        <canvas id="webcamCanvas" width="320" height="320" style="display:none; border-radius: 50%; object-fit: cover;"></canvas>
        <div class="mt-3">
          <button type="button" class="btn btn-primary" id="captureBtn">Capture</button>
          <button type="button" class="btn btn-success" id="uploadBtn" style="display:none;">Upload</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let stream = null;

function isMobile() {
    return /Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i.test(navigator.userAgent);
}

function handleTakePictureClick() {
    if (isMobile()) {
        document.getElementById('profileImageInputCamera').click();
    } else {
        var webcamModal = new bootstrap.Modal(document.getElementById('webcamModal'));
        webcamModal.show();
        setTimeout(startWebcam, 500); // Give modal time to render
    }
}

function startWebcam() {
    const video = document.getElementById('webcamVideo');
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('Webcam not supported in this browser.');
        return;
    }
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(s => {
            stream = s;
            video.srcObject = stream;
            video.play();
            video.style.display = '';
            document.getElementById('webcamCanvas').style.display = 'none';
            document.getElementById('captureBtn').style.display = '';
            document.getElementById('uploadBtn').style.display = 'none';
        })
        .catch(err => {
            alert('Could not access the camera. Please allow camera access.');
        });
}

function stopWebcam() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

document.getElementById('captureBtn').onclick = function() {
    const video = document.getElementById('webcamVideo');
    const canvas = document.getElementById('webcamCanvas');
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    canvas.style.display = '';
    video.style.display = 'none';
    this.style.display = 'none';
    document.getElementById('uploadBtn').style.display = '';
};

document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'uploadBtn') {
        console.log('Upload button clicked (delegated)');
        const canvas = document.getElementById('webcamCanvas');
        if (canvas.width === 0 || canvas.height === 0) {
            alert('No image captured!');
            return;
        }
        canvas.toBlob(function(blob) {
            if (!blob) {
                alert('Failed to capture image from webcam.');
                return;
            }
            let formData = new FormData();
            formData.append('profile_image', blob, 'webcam.jpg');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            fetch('{{ route('hr.profile.upload') }}', {
                method: 'POST',
                body: formData
            }).then(response => {
                stopWebcam();
                var webcamModal = bootstrap.Modal.getInstance(document.getElementById('webcamModal'));
                webcamModal.hide();
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated',
                        text: 'Your profile image has been updated successfully!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        setTimeout(() => {
                            const img = document.querySelector('.user-panel img');
                            if (img) {
                                img.onerror = function() {
                                    location.reload();
                                };
                                img.src = img.src.split('?')[0] + '?v=' + new Date().getTime();
                            }
                        }, 500); // 800ms delay
                    });
                } else {
                    return response.text().then(text => {
                        console.log('Error response:', text);
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: 'There was an error uploading your profile image. Please try again.',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            }).catch(error => {
                stopWebcam();
                var webcamModal = bootstrap.Modal.getInstance(document.getElementById('webcamModal'));
                webcamModal.hide();
                console.error('Fetch error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: 'Upload failed: ' + error.message,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            });
        }, 'image/jpeg', 0.95);
    }
});
</script>
