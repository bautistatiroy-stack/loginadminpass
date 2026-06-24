
<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Modern Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box" id="loginBox">

    <h2>🍔 Food Admin Login</h2>

    <input type="text" id="adminUser" placeholder="Username">
    <input type="password" id="adminPass" placeholder="Password">
    <input type="email" id="adminEmail" placeholder="Email">

    <div>
        <button onclick="goShop()">Back</button>
        <button onclick="loginAdmin()">Login</button>
    </div>

</div>

<!-- ADMIN PANEL -->
<div id="adminPanel" style="display:none;">

    <h1>🛒 Admin Dashboard</h1>

    <button onclick="logoutAdmin()">Logout</button>
    <button onclick="remotecontrol()">Remote Control</button>
     <button onclick="goclientlist()">Client List</button>

    <div class="container">

        <div class="form-box">

            <h2>Add Product</h2>

            <input id="name" placeholder="Product Name">
            <input id="price" type="number" placeholder="Price">
            <input id="stock" type="number" placeholder="Stock">
            <input id="img" placeholder="Image URL">

            <button onclick="addProduct()">Add Product</button>

        </div>

        <div class="products" id="list"></div>

    </div>

</div>
   <script src="adminpass.js"></script>
<script>

const API = "https://script.google.com/macros/s/AKfycbyL-f7sdsoMR2FvX8EgSXpqchMHYD_d_y4kMDuXYsQyFotusCZmIH7iNavYvO4WbjAQ/exec";

/* ================= LOGIN ================= */
function goclientlist(){
    window.location.href="allclientlistorder.php";
}


function goShop(){
    window.location.href="index.html";
}

function remotecontrol(){
    window.location.href="remote.php";
}

/* ================= GOOGLE SHEETS API ================= */

function addProduct(){

let name=document.getElementById("name").value;
let price=document.getElementById("price").value;
let stock=document.getElementById("stock").value;
let img=document.getElementById("img").value;

if(!name||!price||!stock||!img){
    alert("Fill all fields");
    return;
}

fetch(API,{
method:"POST",
body:new URLSearchParams({
action:"add",
name:name,
price:price,
stock:stock,
img:img
})
})
.then(r=>r.text())
.then(res=>{
alert(res);
loadProducts();
clearForm();
});

}

function loadProducts(){

fetch(API)
.then(r=>r.json())
.then(data=>{

let html="";

data.forEach(p=>{

html+=`
<div class="card">

<img src="${p.img}">

<div class="card-content">

<h3>${p.name}</h3>

<div>₱${p.price}</div>

<p>Stock: ${p.stock}</p>

<button onclick="deleteItem('${p.id}')">
Delete
</button>

</div>

</div>
`;

});

document.getElementById("list").innerHTML=html;

});

}

function deleteItem(id){

fetch(API,{
method:"POST",
body:new URLSearchParams({
action:"delete",
id:id
})
})
.then(r=>r.text())
.then(()=>{
loadProducts();
});

}

function clearForm(){
document.getElementById("name").value="";
document.getElementById("price").value="";
document.getElementById("stock").value="";
document.getElementById("img").value="";
}

/* INIT */
loadProducts();

</script>

</body>
</html>

