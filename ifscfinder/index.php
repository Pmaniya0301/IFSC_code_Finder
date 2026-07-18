<?php
session_start();
//error_reporting(0);
include('admin/includes/dbconnection.php');
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    
    <!--====== Title ======-->
    <title>IFSC Code Finder Portal | Home</title>
    
    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="assets/css/slick.css">
        
    <!--====== Font Awesome CSS ======-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        
    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="assets/css/LineIcons.css">
        
    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="assets/css/animate.css">
        
    <!--====== Magnific Popup CSS ======-->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
        
    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="assets/css/default.css">
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="assets/css/style.css">
    
</head>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
   
   
    <!--====== PRELOADER PART START ======-->

    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== PRELOADER PART ENDS ======-->
    
    <!--====== HEADER PART START ======-->
    
    <header class="header-area">
        <div class="navbar-area headroom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                           <h3 style="color: red;padding-right: 50px;">IFSC Code Finder Portal</h3>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav m-auto">
                                    <li class="nav-item active">
                                        <a href="index.php">Home</a>
                                    </li>
                                   
                                    <li class="nav-item">
                                        <a href="admin/login.php">Admin</a>
                                    </li>
                                   
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- navbar area -->
        
        <div id="home" class="header-hero bg_cover d-lg-flex align-items-center" style="background-image: url(assets/images/header-hero.png)">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="header-hero-content">
                            <h1 class="hero-title wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s"><b>Search</b> <span>Bank</span> Detail <b>by one click.</b></h1>
                            <div class="header-singup wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.8s">
                                <form action="search.php" method="post" name="search">
                                <input type="text" placeholder="Enter Bank Name/Zipcode/Branch/IFSC Code" name="searchifsccode">
                                <button class="main-btn"  name="search" id="submit" type="submit">Search</button></form>
                            </div>
                            
                            <!-- Dynamic Branch Locator Widget -->
                            <div class="locator-container mt-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">
                                <h5 class="text-white mb-3" style="font-size: 1.1rem; font-weight: 500;"><i class="fa fa-map-marker"></i> Quick Branch Locator</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <select id="locator-bank" class="form-control locator-select">
                                            <option value="">-- Select Bank --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <select id="locator-state" class="form-control locator-select" disabled>
                                            <option value="">-- Select State --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <select id="locator-city" class="form-control locator-select" disabled>
                                            <option value="">-- Select City --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <select id="locator-branch" class="form-control locator-select" disabled>
                                            <option value="">-- Select Branch --</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="locator-result" class="mt-3 d-none"></div>
                            </div>
                        </div> <!-- header hero content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            <div class="header-hero-image d-flex align-items-center wow fadeInRightBig" data-wow-duration="1s" data-wow-delay="1.1s">
                <div class="image">
                    <img src="assets/images/hero-image.png" alt="Hero Image">
                </div>
            </div> <!-- header hero image -->
        </div> <!-- header hero -->
    </header>
    
 
    <!--====== FOOTER PART START ======-->
    
    <footer id="footer" class="footer-area bg_cover" style="background-image: url(assets/images/footer-bg.jpg)">
        <div class="container">
            <div class="footer-copyright text-center">
                <p class="text">© <?php echo date('Y');?> IFSC Code finder Portal</p>
            </div>
        </div> <!-- container -->
    </footer>
    
    <!--====== FOOTER PART ENDS ======-->
    
    <!--====== BACK TOP TOP PART START ======-->

    <a href="#" class="back-to-top"><i class="lni-chevron-up"></i></a>

    <!--====== BACK TOP TOP PART ENDS ======-->  




    <!--====== Jquery js ======-->
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>
    
    <!--====== Bootstrap js ======-->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
    <!--====== Slick js ======-->
    <script src="assets/js/slick.min.js"></script>
    
    <!--====== Isotope js ======-->
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    
    <!--====== Counter Up js ======-->
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    
    <!--====== Circles js ======-->
    <script src="assets/js/circles.min.js"></script>
    
    <!--====== Appear js ======-->
    <script src="assets/js/jquery.appear.min.js"></script>
    
    <!--====== WOW js ======-->
    <script src="assets/js/wow.min.js"></script>
    
    <!--====== Headroom js ======-->
    <script src="assets/js/headroom.min.js"></script>
    
    <!--====== Jquery Nav js ======-->
    <script src="assets/js/jquery.nav.js"></script>
    
    <!--====== Scroll It js ======-->
    <script src="assets/js/scrollIt.min.js"></script>
    
    <!--====== Magnific Popup js ======-->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    
    <!--====== Main js ======-->
    <script src="assets/js/main.js"></script>

    <!-- Branch Locator Script -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const bankSelect = document.getElementById("locator-bank");
        const stateSelect = document.getElementById("locator-state");
        const citySelect = document.getElementById("locator-city");
        const branchSelect = document.getElementById("locator-branch");
        const resultDiv = document.getElementById("locator-result");

        // Fetch initial list of banks and states
        fetch("get-search-options.php?action=get_banks")
            .then(res => res.json())
            .then(data => {
                data.forEach(bank => {
                    const opt = document.createElement("option");
                    opt.value = bank.id;
                    opt.textContent = bank.name;
                    bankSelect.appendChild(opt);
                });
            });

        fetch("get-search-options.php?action=get_states")
            .then(res => res.json())
            .then(data => {
                data.forEach(state => {
                    const opt = document.createElement("option");
                    opt.value = state.id;
                    opt.textContent = state.name;
                    stateSelect.appendChild(opt);
                });
            });

        // Handle Bank selection change
        bankSelect.addEventListener("change", function() {
            resetDropdowns(['state', 'city', 'branch']);
            if (this.value) {
                stateSelect.disabled = false;
            }
        });

        // Handle State selection change
        stateSelect.addEventListener("change", function() {
            resetDropdowns(['city', 'branch']);
            if (!this.value) return;

            fetch("get-search-options.php?action=get_cities&state_id=" + this.value)
                .then(res => res.json())
                .then(data => {
                    citySelect.disabled = false;
                    data.forEach(city => {
                        const opt = document.createElement("option");
                        opt.value = city.id;
                        opt.textContent = city.name;
                        citySelect.appendChild(opt);
                    });
                });
        });

        // Handle City selection change
        citySelect.addEventListener("change", function() {
            resetDropdowns(['branch']);
            if (!this.value || !bankSelect.value) return;

            fetch(`get-search-options.php?action=get_branches&bank_id=${bankSelect.value}&city_id=${this.value}`)
                .then(res => res.json())
                .then(data => {
                    branchSelect.disabled = false;
                    data.forEach(br => {
                        const opt = document.createElement("option");
                        opt.value = br.id;
                        opt.textContent = br.name;
                        branchSelect.appendChild(opt);
                    });
                });
        });

        // Handle Branch selection change
        branchSelect.addEventListener("change", function() {
            if (!this.value) {
                resultDiv.classList.add("d-none");
                return;
            }

            fetch("get-search-options.php?action=get_branch_details&branch_id=" + this.value)
                .then(res => res.json())
                .then(data => {
                    if (data.error) return;
                    
                    resultDiv.innerHTML = `
                        <div class="rbi-card">
                            <div class="rbi-card-header">
                                <span class="rbi-card-bank">${data.bn}</span>
                                <span class="rbi-card-branch">${data.Branch} Branch</span>
                            </div>
                            <div class="rbi-card-body">
                                <div class="rbi-meta-row">
                                    <div class="rbi-meta-col">
                                        <span class="rbi-label">IFSC CODE</span>
                                        <span class="rbi-value highlight-ifsc">${data.IFSCCode}</span>
                                        <button class="btn-copy-mini" onclick="copyText('${data.IFSCCode}', this)">Copy</button>
                                    </div>
                                    <div class="rbi-meta-col">
                                        <span class="rbi-label">MICR CODE</span>
                                        <span class="rbi-value">${data.MICRCode || 'NA'}</span>
                                    </div>
                                </div>
                                <div class="rbi-meta-row mt-2">
                                    <div class="rbi-meta-full">
                                        <span class="rbi-label">ADDRESS</span>
                                        <span class="rbi-value">${data.Address}</span>
                                    </div>
                                </div>
                                <div class="rbi-meta-row mt-2">
                                    <div class="rbi-meta-col">
                                        <span class="rbi-label">CITY / STATE</span>
                                        <span class="rbi-value">${data.City}, ${data.State}</span>
                                    </div>
                                    <div class="rbi-meta-col">
                                        <span class="rbi-label">CONTACT</span>
                                        <span class="rbi-value">${data.PhoneNumber || 'N/A'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    resultDiv.classList.remove("d-none");
                });
        });

        function resetDropdowns(ids) {
            if (ids.includes('state')) {
                stateSelect.value = "";
                stateSelect.disabled = true;
            }
            if (ids.includes('city')) {
                citySelect.innerHTML = '<option value="">-- Select City --</option>';
                citySelect.value = "";
                citySelect.disabled = true;
            }
            if (ids.includes('branch')) {
                branchSelect.innerHTML = '<option value="">-- Select Branch --</option>';
                branchSelect.value = "";
                branchSelect.disabled = true;
            }
            resultDiv.classList.add("d-none");
        }
    });

    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = btn.textContent;
            btn.textContent = "Copied!";
            btn.classList.add("copied");
            setTimeout(() => {
                btn.textContent = originalText;
                btn.classList.remove("copied");
            }, 2000);
        });
    }
    </script>
    
</body>

</html>
