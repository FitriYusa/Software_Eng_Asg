<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Classroom Equipment Fault System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7fb;
      margin: 0;
      padding: 20px;
      color: #333;
    }
    h1, h2 { margin-top: 0; }
    .card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }
    input, select, textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    textarea { resize: vertical; min-height: 80px; }
    button {
      padding: 10px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }
    .btn-primary { background: #2563eb; color: #fff; }
    .btn-secondary { background: #e5e7eb; color: #333; }

    /* Navigation bar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #2563eb;
      color: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    .navbar a {
      color: #fff;
      text-decoration: none;
      margin-left: 12px;
    }
    .dropdown {
      position: relative;
      display: inline-block;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #fff;
      min-width: 140px;
      box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
      border-radius: 6px;
      z-index: 1;
    }
    .dropdown-content a, .dropdown-content form button {
      color: #333;
      padding: 10px 12px;
      text-decoration: none;
      display: block;
      width: 100%;
      text-align: left;
      background: none;
      border: none;
      cursor: pointer;
    }
    .dropdown-content a:hover, .dropdown-content form button:hover { background-color: #f3f4f6; }
    .dropdown:hover .dropdown-content { display: block; }

    .alert-success { background: #dcfce7; color: #166534; padding: 10px; border-radius: 6px; margin-bottom: 12px; }
  </style>
</head>
<body>

  <!-- Navigation Bar -->
  <div class="navbar">
    <div>
    </div>

    @auth
    <div class="dropdown">
      <span>{{ auth()->user()->name }}</span>
      <div class="dropdown-content">
        @if(Route::has('profile'))
          <a href="{{ route('profile') }}">Profile</a>
        @endif
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit">Logout</button>
        </form>
      </div>
    </div>
    @endauth
  </div>

  <h1>Classroom Equipment Fault System</h1>

  <!-- Success message -->
  @if(session('success'))
    <div class="alert-success">
      {{ session('success') }}
    </div>
  @endif

  <!-- Report Fault Form -->
  <div class="card">
    <h2>Report a Fault</h2>
    <form action="{{ route('report_fault.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <label for="classroom">Classroom</label>
      <input type="text" id="classroom" name="classroom" placeholder="e.g., A-203" required>

      <label for="equipment">Equipment</label>
      <select id="equipment" name="equipment" required>
          <option value="">Select equipment</option>
          <option>Projector</option>
          <option>Computer</option>
          <option>Speaker</option>
          <option>Microphone</option>
          <option>Air Conditioner</option>
      </select>

      <label for="priority">Priority</label>
      <select id="priority" name="priority" required>
          <option>Low</option>
          <option>Medium</option>
          <option>High</option>
      </select>

      <!-- Automatically use logged-in user -->
      <input type="hidden" name="user_id" value="{{ auth()->id() }}">

      <label for="description">Description</label>
      <textarea id="description" name="description" placeholder="Describe the issue..." required></textarea>

      <label for="evidence">Upload Evidence</label>
      <input type="file" id="evidence" name="evidence[]" multiple>

      <button type="submit" class="btn-primary">Submit Fault</button>
      <button type="reset" class="btn-secondary">Clear</button>
    </form>
  </div>

</body>
</html>
