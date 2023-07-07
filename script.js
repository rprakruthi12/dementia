// Get the input element and button
const fileInput = document.getElementById('file-input');
const cameraButton = document.getElementById('camera-button');

// Add event listeners
fileInput.addEventListener('change', handleFileUpload);
cameraButton.addEventListener('click', captureFromCamera);

// Handle file upload
function handleFileUpload(event) {
  const file = event.target.files[0];
  const reader = new FileReader();
  
  reader.onload = function() {
    const previewImg = document.getElementById('preview-img');
    previewImg.src = reader.result;
  }
  
  reader.readAsDataURL(file);
}

// Capture image from camera
function captureFromCamera() {
  const constraints = { video: true };
  
  navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream) {
      const video = document.createElement('video');
      const previewImg = document.getElementById('preview-img');
      
      video.srcObject = stream;
      video.play();
      
      const mediaStreamTrack = stream.getVideoTracks()[0];
      
      const imageCapture = new ImageCapture(mediaStreamTrack);
      imageCapture.takePhoto()
        .then(function(blob) {
          const imageUrl = URL.createObjectURL(blob);
          previewImg.src = imageUrl;
        })
        .catch(function(error) {
          console.error('Error taking photo: ', error);
        });
    })
    .catch(function(error) {
      console.error('Error accessing camera: ', error);
    });
}
