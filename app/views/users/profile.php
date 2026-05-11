<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Happy Care Clinic - Profile</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>

    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
    }

    :root{
      --pink:#e8336d;
      --pink-light:#ff6b9d;
      --pink-grad:linear-gradient(135deg,#e8336d,#ff6b9d);
      --bg:#f4f6fb;
      --white:#ffffff;
      --text:#1a1a2e;
      --muted:#7a7a9a;
      --border:#e8e8f0;
      --green:#43a047;
      --green-pale:#e8f5e9;
    }

    body{
      font-family:'Poppins',sans-serif;
      background:var(--bg);
      color:var(--text);
      min-height:100vh;
      padding:40px 20px;
    }

    .profile-dashboard{
      max-width:1100px;
      margin:auto;
      display:flex;
      gap:30px;
      flex-wrap:wrap;
    }

    /* SIDEBAR */

    .profile-sidebar{
      width:300px;
      background:var(--white);
      border-radius:20px;
      padding:30px 22px;
      border:1px solid var(--border);
      box-shadow:0 4px 18px rgba(0,0,0,0.05);
      display:flex;
      flex-direction:column;
      align-items:center;
    }

    .avatar-circle{
      width:110px;
      height:110px;
      border-radius:50%;
      background:var(--pink-grad);
      margin-bottom:18px;
    }

    .user-details{
      text-align:center;
      margin-bottom:20px;
    }

    .user-details h2{
      font-size:1.2rem;
      margin-bottom:8px;
    }

    .user-role{
      background:#fce4ec;
      color:var(--pink);
      padding:5px 14px;
      border-radius:50px;
      font-size:.82rem;
      font-weight:600;
    }

    .user-contact{
      width:100%;
      border-top:1px solid var(--border);
      border-bottom:1px solid var(--border);
      padding:18px 0;
      margin:18px 0;
    }

    .user-contact p{
      margin:10px 0;
      color:var(--muted);
      font-size:.88rem;
    }

    .sidebar-actions{
      width:100%;
      display:flex;
      flex-direction:column;
      gap:12px;
      margin-top:10px;
    }

    .btn-profile-primary,
    .btn-profile-secondary{
      width:100%;
      padding:12px;
      border-radius:14px;
      border:none;
      font-family:'Poppins',sans-serif;
      font-weight:600;
      cursor:pointer;
      transition:.2s;
    }

    .btn-profile-primary{
      background:var(--pink-grad);
      color:white;
    }

    .btn-profile-primary:hover{
      opacity:.9;
    }

    .btn-profile-secondary{
      background:white;
      border:1.5px solid var(--border);
      color:var(--text);
    }

    .btn-profile-secondary:hover{
      border-color:var(--pink);
      color:var(--pink);
    }

    .security-badge{
      margin-top:22px;
      background:var(--green-pale);
      border-radius:14px;
      padding:16px;
      width:100%;
      text-align:center;
    }

    .security-badge strong{
      display:block;
      color:var(--green);
      margin-bottom:6px;
    }

    .security-badge p{
      font-size:.78rem;
      line-height:1.5;
      color:#555;
    }

    /* CONTENT */

    .profile-content{
      flex:1;
      background:white;
      border-radius:20px;
      padding:35px;
      border:1px solid var(--border);
      box-shadow:0 4px 18px rgba(0,0,0,0.05);
    }

    /* TABS */

    .profile-tabs{
      display:flex;
      gap:20px;
      list-style:none;
      border-bottom:2px solid var(--border);
      margin-bottom:35px;
      flex-wrap:wrap;
    }

    .tab-link{
      padding:12px 5px;
      cursor:pointer;
      color:var(--muted);
      font-weight:600;
      position:relative;
      transition:.2s;
    }

    .tab-link:hover{
      color:var(--text);
    }

    .tab-link.active{
      color:var(--pink);
    }

    .tab-link.active::after{
      content:'';
      position:absolute;
      left:0;
      bottom:-2px;
      width:100%;
      height:3px;
      border-radius:20px;
      background:var(--pink-grad);
    }

    /* PANES */

    .tab-pane{
      display:none;
      animation:fade .3s ease;
    }

    .tab-pane.active{
      display:block;
    }

    @keyframes fade{
      from{
        opacity:0;
        transform:translateY(10px);
      }
      to{
        opacity:1;
        transform:translateY(0);
      }
    }

    /* PROFILE */

    .profile-info h2{
      font-size:1.4rem;
      margin-bottom:8px;
    }

    .profile-subtext{
      color:var(--muted);
      margin-bottom:28px;
      font-size:.9rem;
    }

    .profile-grid{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
      gap:20px;
    }

    .profile-box{
      display:flex;
      flex-direction:column;
    }

    .profile-box label{
      margin-bottom:8px;
      font-size:.85rem;
      font-weight:600;
    }

    .profile-box input{
      padding:13px 15px;
      border-radius:14px;
      border:1.5px solid var(--border);
      outline:none;
      font-family:'Poppins',sans-serif;
      transition:.2s;
    }

    .profile-box input:focus{
      border-color:var(--pink);
      box-shadow:0 0 0 3px rgba(232,51,109,.08);
    }

    .save-btn{
      margin-top:28px;
      padding:13px 35px;
      border:none;
      border-radius:14px;
      background:var(--pink-grad);
      color:white;
      font-family:'Poppins',sans-serif;
      font-weight:600;
      cursor:pointer;
    }

    /* EMPTY STATE */

    .empty-state{
      text-align:center;
      padding:40px 20px;
    }

    .calendar-illustration{
      font-size:4rem;
      margin-bottom:20px;
    }

    .empty-state h3{
      margin-bottom:10px;
    }

    .empty-state p{
      color:var(--muted);
      line-height:1.7;
      font-size:.9rem;
    }

    .empty-state button{
      margin-top:25px;
      padding:13px 30px;
      border:none;
      border-radius:14px;
      background:var(--pink-grad);
      color:white;
      font-family:'Poppins',sans-serif;
      font-weight:600;
      cursor:pointer;
    }

    .payment-box{
      background:#fafafa;
      border:1px solid var(--border);
      padding:25px;
      border-radius:18px;
    }

    .payment-box h3{
      margin-bottom:10px;
    }

    .payment-box p{
      color:var(--muted);
      font-size:.9rem;
    }

    @media(max-width:768px){

      .profile-dashboard{
        flex-direction:column;
      }

      .profile-sidebar{
        width:100%;
      }

      .profile-content{
        padding:25px;
      }

    }

  </style>
</head>

<body>

  <div class="profile-dashboard">

    <!-- SIDEBAR -->

    <aside class="profile-sidebar">

      <div class="avatar-circle"></div>

      <div class="user-details">
        <h2>Christian Nickhos A. Divina</h2>
        <span class="user-role">Patient</span>
      </div>

      <div class="user-contact">
        <p>📧 christiandivina2316@gmail.com</p>
        <p>📍 Legazpi City, Albay</p>
      </div>

      <div class="sidebar-actions">
        <button class="btn-profile-primary">
          Edit Profile
        </button>

        <button class="btn-profile-secondary">
          Logout
        </button>
      </div>

      <div class="security-badge">
        <strong>Your information is secure</strong>
        <p>
          We protect your personal data and keep it private.
        </p>
      </div>

    </aside>

    <!-- CONTENT -->

    <main class="profile-content">

      <ul class="profile-tabs">

        <li class="tab-link active" data-tab="profile-tab">
          Profile
        </li>

        <li class="tab-link" data-tab="appointment-tab">
          Appointment History
        </li>

        <li class="tab-link" data-tab="payment-tab">
          Payment History
        </li>

      </ul>

      <!-- PROFILE TAB -->

      <div class="tab-pane active" id="profile-tab">

        <div class="profile-info">

          <h2>Profile Information</h2>

          <p class="profile-subtext">
            Manage your personal information and account details.
          </p>

          <div class="profile-grid">

            <div class="profile-box">
              <label>Full Name</label>
              <input type="text" value="Christian Nickhos A. Divina">
            </div>

            <div class="profile-box">
              <label>Email Address</label>
              <input type="email" value="christiandivina2316@gmail.com">
            </div>

            <div class="profile-box">
              <label>Location</label>
              <input type="text" value="Legazpi City, Albay">
            </div>

            <div class="profile-box">
              <label>Role</label>
              <input type="text" value="Patient">
            </div>

          </div>

          <button class="save-btn">
            Save Changes
          </button>

        </div>

      </div>

      <!-- APPOINTMENT HISTORY -->

      <div class="tab-pane" id="appointment-tab">

        <div class="empty-state">

          <div class="calendar-illustration">
            📅 ❌
          </div>

          <h3>No appointment history</h3>

          <p>
            You haven't booked any appointments yet.
            <br>
            When you do, they will appear here.
          </p>

          <button>
            Book an Appointment
          </button>

        </div>

      </div>

      <!-- PAYMENT HISTORY -->

      <div class="tab-pane" id="payment-tab">

        <div class="payment-box">

          <h3>Payment History</h3>

          <p>
            Your previous transactions will appear here.
          </p>

        </div>

      </div>

    </main>

  </div>

  <script>

    const tabs = document.querySelectorAll('.tab-link');
    const panes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {

      tab.addEventListener('click', () => {

        tabs.forEach(t => {
          t.classList.remove('active');
        });

        panes.forEach(p => {
          p.classList.remove('active');
        });

        tab.classList.add('active');

        const target = document.getElementById(
          tab.getAttribute('data-tab')
        );

        target.classList.add('active');

      });

    });

  </script>

</body>
</html>