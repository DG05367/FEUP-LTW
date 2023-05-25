function uploadImage() {
    const input = document.getElementById('profilePicture');
    const file = input.files[0];
    
    const formData = new FormData();
    formData.append('image', file);
  
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../actions/action_change_ProfilePic.php', true);
    
    xhr.onload = function() {
      if (xhr.status === 200) {
        console.log('Image uploaded successfully!');
      } else {
        console.error('Image upload failed.');
      }
    };
  
    xhr.send(formData);
  }
  