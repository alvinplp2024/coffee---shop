<?php 

include('conn.php');
//session_start();

global $con;

function getproducts(){
	 global $con;

	 //check if set or not
	 if(!isset($_GET['category'])){        //if it is not set then only then we display all the data
	 	//if(!isset($_GET['']))
         $select_query="Select * from items order by title";      //rand()  limit 0,9
         $result_query=mysqli_query($con,$select_query);
         //$row=mysqli_fetch_assoc($result_query);
         //echo $row['name'];

         while($row=mysqli_fetch_assoc($result_query)){
             $cat_id=$row['item_id'];
             $cat_title=$row['title'];
             $cat_description=$row['description'];
             
             $cat_category=$row['category'];
             $cat_image=$row['image'];
             $cat_author=$row['author'];
             $cat_publisher=$row['publisher'];
             $cat_price=$row['price'];
             
            
            echo "<div class='col-md-4 mb-2'>
          <div class='card'>
            <img src='upload/$cat_image' class='card-img-top' alt='...'>
            <div class='card-body'>
             <h5 class='card-title'><b>Title: </b>$cat_title</h5> <br>
              
              
              <p class='card-text'><b>Price:</b> Ksh.$cat_price/-</p>
              <a href='dashboard.php?add_cart=$cat_id'class='btn btn-success'>Add to cart</a> &nbsp;&nbsp;
              <a href='product_details.php?book_id=$cat_id' class='btn btn-primary'>View more</a>
            </div>
          </div> 
        </div>";
            }

}
}


//getting unique categories
function get_unique_categories(){
	 global $con;
	 if(isset($_GET['category'])){
	 	$category_id=$_GET['category'];
         $select_query="Select * from items where category=$category_id";      
         $result_query=mysqli_query($con,$select_query);

         $num_of_rows=mysqli_num_rows($result_query);
         if($num_of_rows==0){
         	echo "<h4 class='text-center ' style='color:red;'>No stock is available for this category</h4>";
         }

         while($row=mysqli_fetch_assoc($result_query)){
             $cat_id=$row['item_id'];
             $cat_title=$row['title'];
             $cat_description=$row['description'];
             
             $cat_category=$row['category'];
             $cat_image=$row['image'];
             $cat_author=$row['author'];
             $cat_publisher=$row['publisher'];
             $cat_price=$row['price'];
             
            
            echo "<div class='col-md-4 mb-2'>
          <div class='card'>
            <img src='upload/$cat_image' class='card-img-top' alt='...'>
            <div class='card-body'>
             <h5 class='card-title'><b>Title: </b>$cat_title</h5>
              <p class='card-text'>$cat_description</p> <br>
              <p class='card-text'><b>Price:</b> Ksh.$cat_price/-</p>
              <a href='dashboard.php?add_cart=$cat_id'class='btn btn-success'>Add to cart</a>  &nbsp;&nbsp;
              <a href='product_details.php?book_id=$cat_id' class='btn btn-primary'>View more</a>
            </div>
          </div> 
        </div>";
            }
            }
            }



       // displaying categories
      function getcategories(){
         global $con;
      	$select_category="Select * from categories";
        $result_categ=mysqli_query($con,$select_category);
        //$row_data=mysqli_fetch_assoc($result_categ);
        //echo $row_data['name']; 
        //echo $row_data['name']; 
        while($row_data=mysqli_fetch_assoc($result_categ)){
         $cate_name=$row_data['name']; 
        $cate_id=$row_data['id'];
        echo"<li class='nav-item'><a class='nav-link text-dark' href='dashboard.php?category=$cate_id'><h5>$cate_name</h5></a></li>" ;
        }

       
      }

      //searching products
      function search_product(){
          
	 global $con;
         if(isset($_GET['search_product'])){  //when button is clicked only then you search for the data
         	$user_search=$_GET['search2'];//once clicked you have to access data in input
         $search_query="Select * from items where keyword like '%$user_search%'"; //at any position you are having the keyword that data should be displayed for you     
         $result_query=mysqli_query($con,$search_query);

         $num_of_rows=mysqli_num_rows($result_query);
         if($num_of_rows==0){
         	echo "<h4 class='text-center' style='color:red;'>No results found!</h4>";
         }

         while($row=mysqli_fetch_assoc($result_query)){
             $cat_id=$row['item_id'];
             $cat_title=$row['title'];
             $cat_description=$row['description'];
             
             $cat_category=$row['category'];
             $cat_image=$row['image'];
             $cat_author=$row['author'];
             $cat_publisher=$row['publisher'];
             $cat_price=$row['price'];
             
            
            echo "<div class='col-md-4 mb-2'>
          <div class='card'>
            <img src='upload/$cat_image' class='card-img-top' alt='...'>
            <div class='card-body'>
             <h5 class='card-title'><b>Title: </b>$cat_title</h5>
              <p class='card-text'>$cat_description</p> <br>
              <p class='card-text'><b>Price:</b> Ksh.$cat_price/-</p>
              <a href='dashboard.php?add_cart=$cat_id'class='btn btn-success'>Add to cart</a> &nbsp;&nbsp;
              <a href='product_details.php?book_id=$cat_id' class='btn btn-primary'>View more</a>
            </div>
          </div> 
        </div>";
            }
      }
  }

  //view more details 
  function view_details(){
      global $con;

	 //check if set or not
      if(isset($_GET['book_id'])){   
	 if(!isset($_GET['category'])){        
	 $product_id=$_GET['book_id'];
     $select_query="Select * from items where item_id=$product_id";  //is primary->fetch only one data  
         $result_query=mysqli_query($con,$select_query);
         
         while($row=mysqli_fetch_assoc($result_query)){
             $cat_id=$row['item_id'];
             $cat_title=$row['title'];
             $cat_description=$row['description'];
             
             $cat_category=$row['category'];
             $cat_image=$row['image'];
             $cat_author=$row['author'];
             $cat_publisher=$row['publisher'];
             $cat_price=$row['price'];
             
            
            echo "<div class='col-md-4 mb-2'>
          <div class='card'>
            <img src='upload/$cat_image' class='card-img-top' alt='...'>
            <div class='card-body'>
             <h5 class='card-title'><b>Title: </b>$cat_title</h5>
              <br>
              <p class='card-text'><b>Price:</b> Ksh.$cat_price/-</p>
              <a href='dashboard.php?add_cart=$cat_id'class='btn btn-success'>Add to cart</a> &nbsp;&nbsp;
              <a href='dashboard.php' class='btn btn-primary'>Go back</a>
            </div>
          </div> 
        </div>

         <div class='col-md-7'>
          <div class='row'>
            <div class='col-md-12'>
              <h4 class='text-center' style='color:green'>More information</h4>
            </div>

            <div class='col-md-12'><h5><b>Author: </b>$cat_author </h5></div> <br><br>
            <div class='col-md-12'><h5><b>Publisher: </b>$cat_publisher</h5></div><br><br>
            <div class='col-md-12'><h5><b>Description: </b><br>$cat_description</h5></div>
            
          </div>
          
        </div>";
            }

}

  }
}

//getting ip address function
 function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_ISP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  
//$ip = getIPAddress();  
//echo 'User Real IP Address - '.$ip;  

function add_to_cart(){
 if(isset($_GET['add_cart'])){ //only perform this operation if the get variable is set
   global $con;     //bcz we have it in sepatate file
   $get_ip_address = getIPAddress();  // e.g., ::1 will be stored i the variable
   $get_product_id=$_GET['add_cart'];
   $select_query="Select * from cart where ip_address= '$get_ip_address' and product_id = $get_product_id";   //varchar is wrapped in single or double quotes
   $result_query=mysqli_query($con,$select_query);
    
   $num_of_rows=mysqli_num_rows($result_query);
   if($num_of_rows>0){
            echo "<script>alert('This item is already present inside cart')</script>";
            echo "<script>window.open('dashboard.php','_self')</script>";
         }else{

            $insert_query="insert into cart (product_id,ip_address,quantity) values ($get_product_id,'$get_ip_address',0)";
            $result_query=mysqli_query($con,$insert_query);
            echo "<script>alert('Item is added to cart')</script>";
            echo "<script>window.open('dashboard.php','_self')</script>";
         }
 }

}

// number of items in cart
    function cart_number(){
 if(isset($_GET['add_cart'])){ 
   global $con;     
   $get_ip_address = getIPAddress();  
   $select_query="Select * from cart where ip_address= '$get_ip_address'";
   $result_query=mysqli_query($con,$select_query);  
   $count_cart_items=mysqli_num_rows($result_query);
}
   else{

           global $con;     
   $get_ip_address = getIPAddress();  
   $select_query="Select * from cart where ip_address= '$get_ip_address'";
   $result_query=mysqli_query($con,$select_query);  
   $count_cart_items=mysqli_num_rows($result_query);
         }
 
  echo $count_cart_items;
}

   //total cart function
   function total_price(){
    global $con;   // must whenever creating new function
    $get_ip_address = getIPAddress();                   //in this we see relationship btn 2 tables
    $total_price=0;
    $cart_query="Select * from cart where ip_address='$get_ip_address'";
    $result=mysqli_query($con,$cart_query);
    while($row=mysqli_fetch_array($result)){
        $product_id=$row['product_id'];
        $select_products="Select * from items where item_id='$product_id'";
        $result_products=mysqli_query($con,$select_products);
        while($row_product_price=mysqli_fetch_array($result_products)){
            $product_price=array($row_product_price['price']);  //[200,300]
            $product_values=array_sum($product_price);          //[500]
            $total_price+=$product_values;                      //[500]

        } 
    }
    echo $total_price;

   }


   //get user order details
   function user_order_details(){
    global $con;
    $username=$_SESSION['username'];
    $get_details="Select * from customers where username= '$username' ";
    $result=mysqli_query($con,$get_details);
    while ($row_query=mysqli_fetch_array($result)) {
        $user_id=$row_query['id'];
        if(!isset($_GET['my_orders'])){
         // if(!isset($_GET['edit_account'])){
         //   if(!isset($_GET['delete_account'])){
                $get_orders="Select * from myorder where user_id= $user_id and order_status='pending'";
                $result_orders=mysqli_query($con,$get_orders);
                $row_count=mysqli_num_rows($result_orders);

                if($row_count>0){
                    echo "<h3 class='text-center'>You have <span class='text-danger'>$row_count</span> pending orders</h3>
                    <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Order Details</a></p>";
                }
                // else{
                //     echo "<h3 class='text-center'>You have <span class='text-danger'>$row_count</span> pending orders</h3>
                //     <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Order Details</a></p>";
                // }
            
          // }
         // }    
         }
      }


   }
  


?>