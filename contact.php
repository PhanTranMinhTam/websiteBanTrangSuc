﻿<?php 
    require_once "inc/header.php";
?>
 <!--contact area start-->
 <div class="contact_area">
                            <div class="row">
                                   <div class="col-lg-6 col-md-12">
                                       <div class="contact_message">
                                            <h3>Tell us your project</h3>   
                                            <form id="contact-form" method="POST" action="assets/mail.php">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input name="name" placeholder="Name *" type="text">    
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input name="email" placeholder="Email *" type="email">    
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input name="subject" placeholder="Subject *" type="text">   
                                                    </div>
                                                     <div class="col-lg-6">
                                                        <input name="phone" placeholder="Phone *" type="text">   
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="contact_textarea">
                                                            <textarea placeholder="Message *" name="message" class="form-control2"></textarea>     
                                                        </div>   
                                                        <button type="submit"> Send Message </button>  
                                                    </div> 
                                                    <div class="col-12">
                                                        <p class="form-messege">
                                                    </div>
                                                </div>
                                            </form>    
                                        </div> 
                                   </div>
                                  
                                   <div class="col-lg-6 col-md-12">
                                       <div class="contact_message contact_info">
                                            <h3>Liên hệ</h3>    
                                             <p>Giấy chứng nhận đăng ký doanh nghiệp: 0300521758 do Sở Kế hoạch & Đầu tư TP.HCM cấp lần đầu ngày 02/01/2004. Ngành, nghề kinh doanh</p>
                                            <ul>
                                                <li><i class="fa fa-fax"></i>  Address : Tòa nhà DOJI Tower, Số 5 Lê Duẩn, Ba Đình, Hà Nội</li>
                                                <li><i class="fa fa-phone"></i> <a href="#">Email:phantranminhtam2873@gmail.com</a></li>
                                                <li><i class="fa fa-envelope-o"></i> Điện thoại:1800 1168</li>
                                            </ul>        
                                            <h3><strong>Working hours</strong></h3>
                                            <p><strong>Monday – Saturday</strong>:  08AM – 22PM</p>       
                                        </div> 
                                   </div>
                               </div>
                        </div>

                        <!--contact area end-->
                        
                        <!--contact map start-->
                        <div class="contact_map">
                            <div class="row">
                                <div class="col-12">
                                    <iframe src="https://www.google.com/maps/embed?pb" width="500" height="450" style="border:0" allowfullscreen=""></iframe>
                                </div>
                            </div>
                        </div>
                        <!--contact map end-->


                    </div>
                    <!--pos page inner end-->
                </div>
            </div>
            <!--pos page end-->
<?php require_once "inc/footer.php"?>