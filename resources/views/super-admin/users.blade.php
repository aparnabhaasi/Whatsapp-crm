<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="https://ictglobaltech.com/assets/imgs/logo/favicon.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <style>
        .bg-pending{
            background: #fff1d6;
            color: rgb(236, 154, 0);
            padding: 8px 15px;
            border: 2px solid rgb(255, 221, 159);
            width: 75px;
            cursor: pointer;
        }
        .bg-paid{
            background: #e8ffd6;
            color: rgb(47 176 0);
            padding: 8px 15px;
            border: 2px solid rgb(181, 255, 159);
            width: 75px;
            cursor: pointer;
        }
        .form-check-input {
            background-color: red;
            border-color: red;
            padding: 10px 20px ;
        }

        .form-check-input:checked {
            background-color: green;
            border-color: green;
        }

        .t-head-bg{
            background: rgb(207, 255, 207) !important;
            color: rgb(21, 91, 0) !important;
        }
        .search{
            width: 300px;
            padding: 10px;
            border-radius: 50px;
            border: 1px solid rgb(74, 255, 61);
        }
        .search:focus{
            outline: 2px solid rgba(0, 183, 0, 0.219);
        }
        .form-select{
            border-radius: 40px;
            border: 1px solid rgb(74, 255, 61);
            padding: 10px;
            width: 150px;
        }
        .form-select:focus{
            box-shadow: none;
            outline: 2px solid rgba(0, 183, 0, 0.219);
            border: none;
        }
    </style>
</head>
<body style="background: #f2fff2;">

    <div class="p-4 d-flex justify-content-between align-items-center">
        <h5><span style="color: #00ca00;">WhatsApp CRM</span> Super Admin</h5>

        <div class="d-flex">
            <a href="dashboard" class="btn btn-outline-primary rounded-circle py-2 me-3"><i class="fa-solid fa-house"></i></a>
            <a href="/superadmin/user-requests" class="btn btn-outline-secondary rounded-circle py-2 me-3"><i class="fa-solid fa-person-circle-question"></i></a>
            <a href="tickets" class="btn btn-warning px-4 me-3" style="border-radius:50px;">
                Tickets
                @if($ticketCount > 0)
                    <span class="badge bg-danger text-warning">{{ $ticketCount }}</span>
                @endif
            </a>

            <form action="{{ route('superadmin.logout') }}" method="post">
                @csrf
                <button class="btn btn-outline-danger px-3" style="border-radius:50px;">Log out <i class="fa fa-power-off"></i></button>
            </form>
        </div>
    </div>

    <div class="container py-3">
        <h2 class="text-center "><b style="color: #00ca00;">Users Requests</b> </h2>

        <div class="d-flex mt-5 mb-4 justify-content-between">
            <div class="">
                <input type="text" class="search" id="searchInput" placeholder="Search...">
            </div>

             
        </div>

        <table class="table table-hover" id="userTable" style="border: 1px solid rgb(204, 204, 204);">
            <thead>
                <tr style="height: 50px;">
                    <th scope="col" class="t-head-bg">#</th>
                    <th scope="col" class="t-head-bg">Requested By</th>
                    <th scope="col" class="t-head-bg">App ID</th>
                    <th scope="col" class="t-head-bg">Name</th>
                    <th scope="col" class="t-head-bg">Mobile</th>
                    <th scope="col" class="t-head-bg">Email</th>
                    <th scope="col" class="t-head-bg">Status</th>
                    <th scope="col" class="t-head-bg">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                @php
                use App\Models\User;

        // Find the admin user who has the same app_id
        $admin = User::where('app_id', $user->app_id)->where('role', 'admin')->first();
    @endphp
                <tr data-name="{{ $user->name }}" data-mobile="{{ $user->mobile }}" data-email="{{ $user->email }}"
                    data-payment="{{ $user->payment_date == 'pending' ? 'pending' : 'paid' }}"
                    data-status="{{ $user->status }}">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $admin ? $admin->name : 'N/A' }}</td> <!-- Display admin name -->
                    <td>{{ $user->app_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->email }}</td>
                      
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="statusSwitch-{{ $user->id }}" @if ($user->status == 'active') checked @endif
                            onclick="updateUserStatus({{ $user->id }}, this.checked ? 'active' : 'inactive')">
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('delete-user', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-light text-danger"
                                onclick="return confirm('Are you sure? You want to delete this user?')"><i
                                    class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <script>
        // Search Functionality
        document.getElementById('searchInput').addEventListener('input', function () {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('#userTable tbody tr');

            rows.forEach(row => {
                let name = row.dataset.name.toLowerCase();
                let mobile = row.dataset.mobile.toLowerCase();
                let email = row.dataset.email.toLowerCase();

                if (name.includes(searchValue) || mobile.includes(searchValue) || email.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filter by Payment
        document.getElementById('paymentFilter').addEventListener('change', function () {
            let paymentValue = this.value;
            let rows = document.querySelectorAll('#userTable tbody tr');

            rows.forEach(row => {
                let payment = row.dataset.payment;
                if (paymentValue === '' || payment === paymentValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filter by Status
        document.getElementById('statusFilter').addEventListener('change', function () {
            let statusValue = this.value;
            let rows = document.querySelectorAll('#userTable tbody tr');

            rows.forEach(row => {
                let status = row.dataset.status;
                if (statusValue === '' || status === statusValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        </script>


          <p class="fixed-bottom text-center">Powered By ICT Global Tech</p>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function updateUserStatus(userId, status) {
            $.ajax({
                url: '/superadmin/update-status',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId,
                    status: status
                },
                
                error: function(xhr) {
                    alert('Error updating status: ' + xhr.responseJSON.error);
                }
            });
        }
    </script>

    <script>
        document.querySelectorAll('.badge').forEach(function(badge) {
            badge.addEventListener('click', function() {
                const userId = badge.getAttribute('data-id');
                const paymentDateCell = badge.closest('tr').querySelector('.payment-date'); // Get the payment date cell

                // Send an AJAX request to update the payment status
                fetch(`{{ secure_url('superadmin/update-payment-status') }}/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF protection
                    },
                    body: JSON.stringify({ userId: userId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update the badge
                        if (data.payment_date === 'pending') {
                            badge.classList.remove('bg-paid');
                            badge.classList.add('bg-pending');
                            badge.innerText = 'Pending';
                            paymentDateCell.innerText = 'Payment Pending'; // Update the payment date cell
                        } else {
                            badge.classList.remove('bg-pending');
                            badge.classList.add('bg-paid');
                            badge.innerText = 'Paid';
                            paymentDateCell.innerText = moment(data.payment_date).add(1, 'years').format('DD-MM-YYYY'); // Update the payment date cell
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>
