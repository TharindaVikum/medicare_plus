<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare Plus | Home </title>
    <link rel="stylesheet" href="home CSS.css">

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Tinos&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Yrsa:ital,wght@0,300..700;1,300..700&display=swap"
        rel="stylesheet">
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f7f9fb;
    color: #333;
}

/* HEADER + HERO SECTION */
.hero {
    background: linear-gradient(to right, rgba(4, 81, 81, 0.747), rgba(77, 125, 125, 0.193)),
        url('ooo.jpg') center/cover no-repeat;
    color: white;
    min-height: 100vh;
    position: relative;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px 70px;
}

header h1 {
    font-size: 26px;
    font-weight: 600;
    color: #fff;
    font-family: "DM Serif Text", serif;
}

nav {
    display: flex;
    align-items: center;
    gap: 30px; /* space between links and button */
}

nav ul {
    display: flex;
    gap: 30px;
    list-style: none;
    margin: 0;
    padding: 0;
}

nav a {
    text-decoration: none;
    color: #fff;
    font-weight: 500;
    font-family: "Tinos", serif;
    font-size: 19px;
}

.login-btn {
    padding: 8px 18px;
    background: #23a5e6b3;
    color: #ffffff;
    border-radius: 25px;
    font-weight: 100;
    text-decoration: none;
    transition: .3s;
    font-family: "Tinos", serif;
    font-size: 19px;
}

.login-btn:hover {
    background: #c8f6ff;
    color: #008080; /* optional hover color */
}



.hero-content {

    position: absolute;
    top: 50%;/* vertical center */
    left: 80px; /* move content to the right side */
    transform: translateY(-50%);/* perfectly center vertically */
    text-align: right;/* center text within the block */
    color: white;
    max-width: 500px;
    z-index: 2;
    text-align: right;
    align-items: flex-start;
    flex-direction: column-reverse;


/* Hero content fade-in from below */

    opacity: 0;
    /* initially invisible */
    transform: translateY(50px);
    /* start slightly below */
    animation: fadeInUp 1s forwards;
    /* run animation on page load */
    animation-delay: 0.3s;
    /* optional delay */
    
}



/* Keyframes for fade-in-up effect */
@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
        /* move to original position */
    }
}



.hero-content h2 {
    font-size: 56px;
    margin-bottom: 20px;
    text-align: left;
    top: 50%;
    right: 80px;
    font-family: "Tinos", serif;
    font-weight: 700;
    font-style: normal;
    transform: translateY(30px);
    animation: fadeInUp 1s forwards;
    animation-delay: 0.3s;
}



.hero-content p {
    font-size: 20px;
    line-height: 1.6;
    text-align: left;
    margin-bottom: 30px;
    color: #e0f7fa;
    font-family: "Tinos", serif;
    font-size: 18px;
    transform: translateY(30px);
    animation: fadeInUp 1s forwards;
    animation-delay: 0.6s;
}

.hero-btn {
    background-color: #fff;
    color: #008080;
    border: none;
    padding: 12px 25px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
    text-decoration: none;
    text-align: center;
    display: inline-block;    /* prevents stretching */
    margin-top: 20px;         /* spacing under the paragraph */
    align-items: right; /* aligns button to the left */
    width: 210px;  
}



.hero-btn:hover {
    background-color: #e6f9f9;
}

.hero-content .hero-btn {
    display: block;
    margin-top: 20px;
    text-align: left; 
}



/* HERO STATS OVERLAY */
.stats-hero {
    position: absolute;
    bottom: 40px;
    /* distance from bottom */
    right: 40px;
    /* distance from left */
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    z-index: 2;
    opacity: 0;
    transform: translateY(50px);
    animation: fadeInUp 1s forwards;
    animation-delay: 1.2s;
    /* after hero text animation */

}

.stats-hero .stat-card {
    font-family: 'Tinos', serif;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 20px 25px;
    border-radius: 12px;
    color: #fff;
    text-align: center;
    min-width: 160px;
    transition: transform 0.3s, background 0.3s;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s forwards;


}

/*
.stats-hero .stat-card .h3 {
    font-family: "Tinos", serif;
    font-size: 20px;
} */

.stats-hero .stat-card p {
    font-family: 'Tinos', serif;
    /* labels */
    font-size: 20px;
    color: #e0f7fa;
}


.stats-hero .stat-card:nth-child(1) {
    opacity: 0;
    transform: translateY(30px);
    animation-delay: 1.3s;
}

.stats-hero .stat-card:nth-child(2) {
    opacity: 0;
    transform: translateY(30px);
    animation-delay: 1.5s;
}

.stats-hero .stat-card:nth-child(3) {
    opacity: 0;
    transform: translateY(30px);
    animation-delay: 1.7s;
}

.stats-hero .stat-card:nth-child(4) {
    opacity: 0;
    transform: translateY(30px);
    animation-delay: 1.9s;

}

.stats-hero .stat-card:nth-child(5) {
    opacity: 0;
    transform: translateY(30px);
    animation-delay: 2.1s;
}

.stats-hero .stat-card:nth-child(6) {
    opacity: 0;
    transform: translateY(30px);
    animation-delay: 2.3s;
}

/* Reuse existing fadeInUp keyframes */
@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stats-hero .stat-card:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.327);
}

.stats-hero .stat-card h3 {
    font-size: 20px;
    margin-bottom: 5px;
    font-weight: 700;
}

.stats-hero .stat-card p {
    font-size: 14px;
    color: #e0f7fa;
}

/* Responsive */
@media (max-width: 768px) {
    .stats-hero {
        bottom: 20px;
        left: 20px;
        gap: 10px;
    }

    .stats-hero .stat-card {
        min-width: 120px;
        padding: 12px 15px;
    }
}


/* DEPARTMENTS SECTION */
.departments {
    text-align: center;
    padding: 70px 60px 40px; /* reduced bottom padding from 70px to 40px */
    background: #fff;
    margin-bottom: 0; /* remove extra spacing below */
}

.departments h2 {
    color: #008080;
    margin-bottom: 40px;
    font-size: 35px;
    font-family: "Yrsa", serif;
}

.dept-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    /* 3 equal-width columns */
    gap: 30px;
    /* smaller spacing */
    justify-items: stretch;
    /* make cards fill the full column */
    align-items: stretch;
    margin-top: 20px;
}

.dept-card {
    background-color: #9ff0f077;
    padding: 30px;
    border-radius: 12px;
    transition: all 0.8s ease-out;
    opacity: 0;
    transform: translateY(50px);
    min-height: 230px;

    /* Centering styles */
    display: flex;
    flex-direction: column; /* stack items vertically */
    justify-content: center; /* center vertically */
    align-items: center; /* center horizontally */
    text-align: center; /* center text content */
    width: 100%;
    max-width: none;
}


.dept-card.show {
    opacity: 1;
    transform: translateY(0);
}

.dept-card:hover {
    background-color: #35e7e783;
    transform: translateY(-5px);
}

.dept-card i {
    font-size: 35px;
    color: #008080;
    margin-bottom: 15px;
}

.dept-card h3 {
    margin-bottom: 10px;
    color: #006666;
    font-family: "Yrsa", serif;
    font-size: 30px;
}

.dept-card p {
    font-size: 15px;
    color: #555;
    font-family: 'Times New Roman', Times, serif;
}

.dept-btn {
    background-color: #008080;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-size: 15px;
    margin-top: 15px;
    transition: all 0.3s ease;
    font-family: 'Times New Roman', Times, serif;
    text-decoration: none;
}


.dept-btn:hover {
    background-color: #00a0a0;
    /* lighter teal on hover */
    transform: translateY(-3px);
    /* subtle lift effect */
}

.about-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 60px 10% 80px; /* reduced top padding */
  background: #fff;
  gap: 60px;
  flex-wrap: wrap;
  margin-top: 0; /* remove extra top margin */
}

/* LEFT SIDE */
.about-content {
  flex: 1;
  min-width: 320px;
}

.about-content h2 {
  font-size: 38px;
  color: #2570b7;
  margin-bottom: 10px;
  font-family:  "Tinos", serif;
}

.about-content p {
  color: #4f5d75;
  font-size: 17px;
  line-height: 1.6;
  margin-bottom: 40px;
  font-family:  "Tinos", serif;
}

/* INFO BOXES */
.about-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 25px 40px;
}

.about-item h3 {
  font-size: 28px;
  color: #08a4b2;
  margin-bottom: 5px;
  font-family:  "Tinos", serif;
}

.about-item h4 {
  font-size: 18px;
  font-weight: 600;
  color: #05555d;
  margin-bottom: 8px;
  font-family:  "Tinos", serif;
}

.about-item p {
  color: #4f5d75;
  font-size: 15px;
  line-height: 1.6;
  font-family: 'Times New Roman', Times, serif;
}

/* BUTTON */
/* Know More Button */
.know-btn {
  display: inline-block;
  margin-top: 40px;
  background-color: #12929d;
  color: white;
  text-decoration: none; /* No underline */
  border: none;
  padding: 12px 28px;
  border-radius: 25px;
  cursor: pointer;
  font-weight: 500;
  font-family: "Tinos", serif;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

/* Hover Effect */
.know-btn:hover {
  background-color: #267387; /* Changes only the button color */
  color: white; /* Keeps text white */
  text-decoration: none; /* Still no underline */
  transform: translateY(-2px);
}


/* RIGHT IMAGE */
.about-image {
  flex: 1;
  min-width: 350px;
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.about-image img {
  width: 100%;
  height: auto;
  display: block;
  transition: transform 0.8s ease;
  border-radius: 15px;
}

.about-image img:hover {
  transform: scale(1.05);
}

/* ANIMATIONS */
.fade-left,
.fade-right,
.fade-up {
  opacity: 0;
  transition: opacity 1s ease, transform 1s ease;
}

.fade-left {
  transform: translateX(-60px);
}

.fade-right {
  transform: translateX(60px);
}

.fade-up {
  transform: translateY(60px);
}

.show {
  opacity: 1;
  transform: translateX(0) translateY(0);
}

.delay { transition-delay: 0.2s; }
.delay-2 { transition-delay: 0.4s; }
.delay-3 { transition-delay: 0.6s; }
.delay-4 { transition-delay: 0.8s; }

/* RESPONSIVE */
@media (max-width: 900px) {
  .about-section {
    flex-direction: column;
    text-align: center;
  }

  .about-grid {
    grid-template-columns: 1fr;
  }

  .about-image {
    margin-top: 40px;
  }
}


.explore-btn {
  background: linear-gradient(135deg, #7b61ff, #a88bff);
  color: white;
  border: none;
  border-radius: 30px;
  padding: 12px 32px;
  cursor: pointer;
  font-weight: 600;
  box-shadow: 0 6px 20px rgba(123, 97, 255, 0.3);
  transition: all 0.3s ease;
}

.explore-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(123, 97, 255, 0.4);
}

/* ANIMATIONS */
.fade-left,
.fade-right {
  opacity: 0;
  transition: opacity 1s ease, transform 1s ease;
}

.fade-left {
  transform: translateX(-60px);
}

.fade-right {
  transform: translateX(60px);
}

.show {
  opacity: 1;
  transform: translateX(0);
}

/* Delays for staggered fade */
.delay {
  transition-delay: 0.2s;
}
.delay-2 {
  transition-delay: 0.4s;
}

/* RESPONSIVE DESIGN */
@media (max-width: 900px) {
  .about-us-section {
    flex-direction: column;
    text-align: center;
  }

  .about-left {
    grid-template-columns: 1fr;
  }

  .about-right {
    max-width: 100%;
  }
}


@media (max-width: 768px) {
    header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        padding: 20px;
    }

    .hero-content {
        padding: 60px 30px;
    }

    .about {
        flex-direction: column;
        align-items: center;
    }

    .about img {
        width: 100%;
        max-width: 350px;
    }
}

@media (max-width: 992px) {
    .dept-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .dept-grid {
        grid-template-columns: 1fr;
    }
}

/* Slide-in from left animation */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-80px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/*online services part*/

.services-section {
  text-align: center;
  padding: 100px 80px;
  background-color: #0d89c68b;
}

.services-section h2 {
  font-size: 36px;
  color: #000000ff;
  margin-bottom: 15px;
  font-family: "Tinos", serif;
}

.services-section p {
  font-size: 17px;
  color: #000000;
  margin-bottom: 60px;
  font-family: 'Times New Roman', Times, serif;
}

/* GRID LAYOUT */
.services-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
  justify-items: stretch;
  align-items: stretch;
}

/* SERVICE CARD */
.service-card {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background: #ffffff;
  border-radius: 10px;
  text-align: center;
  text-decoration: none;
  color: inherit;
  transition: all 0.4s ease;
  opacity: 0;
  transform: translateY(40px);
  min-height: 260px;
  padding: 35px 25px;
  box-sizing: border-box;
}

/* IMAGE INSIDE CARD */
.service-card img {
  width: 70px;
  height: 70px;
  object-fit: contain;
  margin-bottom: 15px;
  transition: transform 0.4s ease;
}

.service-card h3 {
  font-size: 20px;
  font-family: "Tinos",serif;
  color: #000000ff;
  margin-bottom: 10px;
  font-weight: 600;
}

.service-card p {
  font-size: 17px;
  color: #080808ff;
  font-family: 'Times New Roman', Times, serif;
}

/* Hover Effect */
.service-card:hover {
  background: #abe6f3;
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.service-card:hover img {
  transform: scale(1.1);
}

/* Fade + Slide Animations */
.fade-up,
.fade-left,
.fade-right {
  opacity: 0;
  transition: opacity 1s ease, transform 1s ease;
}

.fade-up {
  transform: translateY(60px);
}
.fade-left {
  transform: translateX(-60px);
}
.fade-right {
  transform: translateX(60px);
}

.show {
  opacity: 1;
  transform: translate(0, 0);
}

/* RESPONSIVE */
@media (max-width: 992px) {
  .services-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .services-grid {
    grid-template-columns: 1fr;
  }
}

.news-section {
  padding: 60px 8%;
  background-color: #95caf5ff;
  
}

.section-title {
  text-align: center;
  font-family: 'Times New Roman', Times, serif;
  font-size: 2rem;
  color: rgba(255, 255, 255, 1);
  margin-bottom: 40px;
}

.news-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 30px;
  font-family: 'Times New Roman', Times, serif;
}

.news-main {
  position: relative;
}

.news-main img {
  width: 100%;
  border-radius: 0;
}

.news-content {
  padding: 15px 0;
  font-family: 'Times New Roman', Times, serif;
}

.news-content h3 {
  color: #ffffffff;
  font-size: 1.5rem;
  margin-bottom: 10px;
  font-family: 'Times New Roman', Times, serif;
}

.news-side {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.news-item {
  background: white;
  border-radius: 0;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  overflow: hidden;
  transition: transform 0.3s;
}

.news-item:hover {
  transform: translateY(-5px);
}

.news-item img {
  width: 100%;
  height: auto;
}

.news-item p {
  padding: 10px;
  color: #333;
  font-weight: 500;
  font-family: 'Times New Roman', Times, serif;
}

.news-bottom {
  grid-column: 1 / 3;
  display: flex;
  gap: 25px;
  margin-top: 40px;
}

.news-card {
  background: #ffffffff;
  border-radius: 0;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  flex: 1;
  transition: transform 0.3s;
}

.news-card:hover {
  transform: translateY(-5px);
}

.news-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.news-card h4 {
  padding: 15px;
  color: #000000ff;
  font-weight: 500;
  font-family: 'Times New Roman', Times, serif;
  text-decoration: none; 
}

/* Fade & Slide Animations */
.fade-up, .fade-left, .fade-right {
  opacity: 0;
  transform: translateY(30px);
  transition: all 1s ease-out;
}

.fade-left {
  transform: translateX(-40px);
}

.fade-right {
  transform: translateX(40px);
}

.show {
  opacity: 1;
  transform: translate(0);
}

.read-more {
    display: inline-block;
    margin-top: 10px;
    color: #008080;
    font-weight: bold;
    text-decoration: none;
    font family: 'Times New Roman', Times, serif;
}

.read-more:hover {
    text-decoration: none;
}

/* Footer */
.footer {
  background: #0d1b2a;
  color: #ffffff;
  padding: 50px 0 20px;
  margin-top: 50px;
}

.footer-container {
  width: 85%;
  margin: auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 40px;
}

.footer-section h2,
.footer-section h3 {
  margin-bottom: 15px;
  font-weight: 600;
  font-family:'Times New Roman', Times, serif;
}

.footer-section p {
  line-height: 1.6;
  color: #e0e0e0;
  font-family:'Times New Roman', Times, serif;
}

.footer-section ul {
  list-style: none;
  padding: 0;
   font-family:'Times New Roman', Times, serif;
}

.footer-section ul li {
  margin-bottom: 8px;
   font-family:'Times New Roman', Times, serif;
}

.footer-section ul li a {
  color: #e0e0e0;
  text-decoration: none;
  transition: 0.3s;
   font-family:'Times New Roman', Times, serif;
}

.footer-section ul li a:hover {
  color: #00a8e8;
}

.social-icons a {
  display: inline-block;
  margin-right: 10px;
  color: white;
  font-size: 20px;
  transition: 0.3s ease;
}

.social-icons a:hover {
  color: #00a8e8;
}

.footer-bottom {
  text-align: center;
  padding-top: 20px;
  border-top: 1px solid #33415c;
  margin-top: 30px;
}

.footer-bottom p {
  font-size: 14px;
  color: #cfd6e1;
}



</style>
</head>

<body>

    <div class="hero">
        <header>
            <h1>MediCare Plus</h1>
            <nav>
                <ul>
                    <li><a href="medicare_homepage.php">Home</a></li>
                    <li><a href="aboutus.html">About Us</a></li>
                    <li><a href="department.html">Departments</a></li>
                    <li><a href="doctors.html">Doctors</a></li>
                    <li><a href="contactus.html">Contact Us</a></li>
                </ul>
                            <a href="login.php" target="_blank"   class="login-btn">Login</a>

            </nav>
        </header>

        <div class="hero-content">
            <h2>Trusted Hands,
                Advanced Care.
            </h2>
            <p>Your health is our top priority. Experience world-class treatment and compassionate care.</p>
            <a href="login.php" target="_blank" class="hero-btn">Book Appointment</a>
        </div>
    </div>
    <div class="stats-hero">
        <div class="stat-card">
            <h3>5000+</h3>
            <p>Patients Enrolled</p>
        </div>
        <div class="stat-card">
            <h3>98%</h3>
            <p>Patient Satisfaction</p>
        </div>
        <div class="stat-card">
            <h3>3,500+</h3>
            <p>Consultations</p>
        </div>
        <div class="stat-card">
            <h3>500+</h3>
            <p>Test Offers</p>
        </div>
        <div class="stat-card">
            <h3>400+</h3>
            <p>Tests per Day</p>
        </div>
        <div class="stat-card">
            <h3>800+</h3>
            <p>Consultants</p>
        </div>
    </div>


<section class="about-section">
  <div class="about-content fade-left">
    <h2>Why Choose Us?</h2>
    <p>Our dedicated team of specialists, nurses, and staff work together to provide personalized treatments in a safe, comfortable, 
        and modern environment. Your health and well-being are always our top priority.</p>

    <div class="about-grid">
      <div class="about-item fade-up">
        <h3>1.</h3>
        <h4>Compassionate Care</h4>
        <p>Delivering patient-centered treatments with empathy and respect.</p>
      </div>

      <div class="about-item fade-up delay">
        <h3>2.</h3>
        <h4>Advanced Technology</h4>
        <p>Equipped with modern facilities to ensure accurate diagnosis and treatment.</p>
      </div>

      <div class="about-item fade-up delay-2">
        <h3>3.</h3>
        <h4>Expert Specialists</h4>
        <p>Our team of experienced doctors ensures world-class healthcare services.</p>
      </div>

      <div class="about-item fade-up delay-3">
        <h3>4.</h3>
        <h4>Patient Trust</h4>
        <p>
Building lifelong relationships through transparency and exceptional care.
</p>
      </div>
    </div>

    <a href="aboutus.html" class="know-btn fade-up delay-4">Know More</a>

  </div>

  <div class="about-image fade-right">
    <img src="about.jpg" alt="About Us Image">
  </div>
</section>

 

 <section class="services-section">
  <h2 class="fade-up">Our Services</h2>
  <p class="fade-up delay">
    Explore the convenience of MediCare Plus online services designed to make your healthcare journey easier.
  </p>

  <div class="services-grid">
    <a href="login.php" class="service-card fade-left">
      <img src="report.png" alt="Lab Reports">
      <h3>Download Lab Reports</h3>
      <p>Access your test results quickly and securely.</p>
    </a>

    <a href="login.php" class="service-card fade-right">
      <img src="consult.png" alt="Consultation Bookings">
      <h3>Consultation Bookings</h3>
      <p>Book appointments with your preferred specialists.</p>
    </a>

    <a href="login.php" class="service-card fade-left">
      <img src="regi.png" alt="Pre-Registration">
      <h3>Pre-Registration</h3>
      <p>Save time by completing your registration online.</p>
    </a>

    <a href="login.php" class="service-card fade-right">
      <img src="pharmacy.png" alt="Online Pharmacy">
      <h3>Online Pharmacy</h3>
      <p>Order your medications and have them delivered home.</p>
    </a>

    <a href="login.php" class="service-card fade-left">
      <img src="ppp.png" alt="Payment Portal">
      <h3>Payment Portal</h3>
      <p>Make secure online payments for your medical bills.</p>
    </a>

    <a href="login.php" class="service-card fade-right">
      <img src="feedback.png" alt="Patient Feedback">
      <h3>Patient Feedback</h3>
      <p>Share your experience to help us serve you better.</p>
    </a>
  </div>
</section>


    <section class="departments">
        <h2>Our Departments</h2>
        <div class="dept-grid">
            <div class="dept-card">
                <i class="fas fa-heartbeat"></i>
                <h3>Cardiology</h3>
                <p>Keeping hearts healthy, one beat at a time.</p>
                <a href="cardiology.html" class="dept-btn">See More</a>

            </div>
            <div class="dept-card">
                <i class="fas fa-file-medical-alt"></i>
                <h3>Neurology</h3>
                <p>Caring for the command center of your body.</p>
                <a href="neurology.html" class="dept-btn">See More</a>
            </div>
            <div class="dept-card">
                <i class="fas fa-user-md"></i>
                <h3>Pediatrics</h3>
                <p>Gentle care for little hearts and big smiles.</p>
                <a href="pediatrics.html" class="dept-btn">See More</a>
            </div>
            <div class="dept-card">
                <i class="fas fa-ambulance"></i>
                <h3>Orthopedics</h3>
                <p>Restoring movement, rebuilding strength.</p>
                <a href="orthopedics.html" class="dept-btn">See More</a>
            </div>
            <div class="dept-card">
                <i class="fas fa-ambulance"></i>
                <h3>Gynecology & Obstetrics</h3>
                <p>Supporting women through every stage of life.</p>
                <a href="gynocology.html" class="dept-btn">See More</a>
            </div>
            <div class="dept-card">
                <i class="fas fa-ambulance"></i>
                <h3>Dermatology</h3>
                <p>Healthy skin, healthy confidence.</p>
                <a href="dermatology.html" class="dept-btn">See More</a>
            </div>
            <div class="dept-card">
                <i class="fas fa-ambulance"></i>
                <h3>Dentistry</h3>
                <p>Bright smiles begin here.</p>
                <a href="dentistry.html" class="dept-btn">See More</a>
            </div>
            <div class="dept-card">
                <i class="fas fa-ambulance"></i>
                <h3>Emergency & Trauma Care</h3>
                <p>Here for you. Every second counts.</p>
                <a href="emergency.html" class="dept-btn">See More</a>
            </div>
            <div class="dept-card">
                <i class="fas fa-ambulance"></i>
                <h3>Physiotheraphy</h3>
                <p>Helping you move forward.</p>
                <a href="physiotheraphy.html" class="dept-btn">See More</a>
            </div>


        </div>
    </section>
    
    

    <section class="news-section">
  <h2 class="section-title fade-up">📰 Latest Medical News & Health Tips</h2>
  
<div class="news-grid">
    <!-- Main Large Article -->
    <div class="news-main fade-left">
        <img src="heart disease.jpg" alt="Heart Health">
        <div class="news-content">
            <h3>How to Prevent Heart Disease</h3>
            <p style>
                Heart disease is one of the most common
                health problems today, but it’s largely
                preventable with a healthy lifestyle. 
                You can reduce your risk by eating nutritious 
                foods, staying physically active, avoiding smoking,
                maintaining a healthy weight, and keeping your 
                blood pressure, cholesterol, and blood sugar 
                under control. Managing stress, limiting alcohol, 
                and getting enough sleep also play an important role.
                By making these simple, consistent changes, you can 
                protect your heart and improve your overall well-being.
            </p>

            <!-- Read More Link -->
            <a href="https://www.cdc.gov/heart-disease/prevention/index.html" target="_blank" class="read-more">
               Read more about heart disease prevention
            </a>

        </div>
    </div>




  <div class="news-side fade-right">
  <div class="news-item">
    <a href="https://www.cdc.gov/chronic-disease/prevention/preventive-care.html" target="_blank">
      <img src="check.jpg" alt="Checkup">
      <p>The Importance of Regular Checkups</p>
    </a>
  </div>
 <!-- Bottom 3 Boxes -->
<div class="news-bottom">
  
  <!-- Healthy Diets -->
  <div class="news-card fade-up">
    <a href="https://www.health.harvard.edu/topics/diet-and-weight-loss" target="_blank">
      <img src="healthy food.jpg" alt="Diet">
      <h4>Healthy Diets That Actually Work</h4>
    </a>
  </div>

  <!-- Sleep & Immunity -->
  <div class="news-card fade-up">
    <a href="https://www.cdc.gov/sleep/about_sleep/how-sleep-affects-health.html" target="_blank">
      <img src="sleep.jpg" alt="Sleep">
      <h4>How Sleep Affects Your Immunity</h4>
    </a>
  </div>

  <!-- Vaccine Research -->
  <div class="news-card fade-up">
    <a href="https://www.who.int/news-room/fact-sheets/detail/immunization" target="_blank">
      <img src="vaccine.jpg" alt="Vaccines">
      <h4>Latest Vaccine Research 2025</h4>
    </a>
  </div>

</div>

</section>

<footer class="footer">
  <div class="footer-container">
    
    <div class="footer-section about">
      <h2>Medicare Plus</h2>
      <p>Your trusted partner in health. We provide advanced medical care, friendly service, and expert doctors.</p>
    </div>

    <div class="footer-section links">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="medicare_homepage.php">Home</a></li>
        <li><a href="aboutus.html">About Us</a></li>
        <li><a href="department.html">Departments</a></li>        
        <li><a href="doctors.html">Doctors</a></li>
        <li><a href="contactus.html">Contact Us</a></li>
        
        
      </ul>
    </div>

    <div class="footer-section contact">
      <h3>Contact Info</h3>
      <p><strong>Phone:</strong> +94 71 234 5678</p>
      <p><strong>Email:</strong> info@medicareplus.com</p>
      <p><strong>Address:</strong> No. 07, Main Street, Colombo</p>
    </div>


  </div>

  <div class="footer-bottom">
    <p>© 2025 Medicare Plus. All Rights Reserved.</p>
  </div>
</footer>



    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Select both stat and department cards
            const cards = document.querySelectorAll(".stat-card, .dept-card");

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                    } else {
                        entry.target.classList.remove("show"); // optional fade-out when leaving
                    }
                });
            }, { threshold: 0.2 }); // triggers when 20% of element is visible

            cards.forEach(card => observer.observe(card));
        });
    </script>

 <script>
document.addEventListener("DOMContentLoaded", () => {
  const aboutSection = document.querySelector(".about");

  // Observe when the about section enters/leaves the screen
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        aboutSection.classList.add("active"); // Trigger slide-in
      } else {
        aboutSection.classList.remove("active"); // Remove when out of view
      }
    });
  }, { threshold: 0.2 }); // Trigger when 20% is visible

  observer.observe(aboutSection);
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const fadeElements = document.querySelectorAll(".fade-left, .fade-right, .fade-up");

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
      } else {
        // Remove the class when scrolled out — so animation replays
        entry.target.classList.remove("show");
      }
    });
  }, { threshold: 0.2 });

  fadeElements.forEach(el => observer.observe(el));
});
</script>

<script>
  const fadeEls = document.querySelectorAll('.fade-up, .fade-left, .fade-right');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      }
    });
  }, { threshold: 0.2 });

  fadeEls.forEach(el => observer.observe(el));
</script>
<script>
  const fadeElements = document.querySelectorAll('.fade-up, .fade-left, .fade-right');

  const fadeObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      } else {
        entry.target.classList.remove('show'); // allows animation to replay
      }
    });
  }, { threshold: 0.2 });

  fadeElements.forEach(el => fadeObserver.observe(el));
</script>

<script>
  const fadeElementsNews = document.querySelectorAll('.fade-up, .fade-left, .fade-right');
  const newsFadeObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      }
    });
  }, { threshold: 0.2 });

  fadeElementsNews.forEach(el => newsFadeObserver.observe(el));
</script>











</body>

</html>