let listMhs = document.getElementsByTagName("ul");
listMhs[0].addEventListener('click', tampilkan);

function tampilkan(e){
    alert('cek data mahasiswa '+e.target.innerHTML);
}