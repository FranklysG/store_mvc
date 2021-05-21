// console.log('oi');
const $ = document;
const upload = $.querySelector('#file');
upload.addEventListener('change', function(event){
    const reader = new FileReader();
    reader.addEventListener('load', () => {
        // console.log(reader.result);
        localStorage.setItem('recent-image', reader.result);
        $.querySelector('#image-recent').setAttribute('src', reader.result)
    });
    reader.readAsDataURL(this.files[0]);

});
