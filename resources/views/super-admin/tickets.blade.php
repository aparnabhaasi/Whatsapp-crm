<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Tickets</title>
    <link rel="icon" type="image/x-icon" href="https://ictglobaltech.com/assets/imgs/logo/favicon.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- font awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .bg-pending{
            background: #fff1d6;
            color: #e45000;
            padding: 8px 15px;
            border: 2px solid rgb(255, 221, 159);
            width: 75px;
            cursor: pointer;
        }
        .bg-paid{
            background: #e8ffd6;
            color: #2faf00;
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

        .form-check-label::before {
            background-color: white;
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

            <a href="tickets" class="btn btn-warning px-4 me-3" style="border-radius:50px;">Tickets</a>
            <form action="{{ route('superadmin.logout') }}" method="post">
                @csrf
                <button class="btn btn-outline-danger px-3" style="border-radius:50px;">Log out <i class="fa fa-power-off"></i></button>
            </form>
        </div>
    </div>

    <div class="container py-3">
        <h2 class="text-center my-4"><b style="color: #00ca00;">WhatsAp CRM</b> Tickets</h2>

        <div class="d-flex mt-5 mb-4 justify-content-between">
            <div class="">
                <input type="text" id="searchInput" class="search" placeholder="Search...">
            </div>
    
            <div class="d-flex">
                <div>
                    <select class="form-select" aria-label="Default select example" id="statusFilter">
                        <option value="all" selected>All</option>
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                    </select>
                </div>
            </div>
        </div>

        <table class="table table-hover" style="border: 1px solid rgb(204, 204, 204);">
            <thead>
              <tr style="height: 50px;">
                <th scope="col" class="t-head-bg">#</th>
                <th scope="col" class="t-head-bg">App ID</th>
                <th scope="col" class="t-head-bg">Name</th>
                <th scope="col" class="t-head-bg">Mobile</th>
                <th scope="col" class="t-head-bg">Email</th>
                <th scope="col" class="t-head-bg">Description</th>
                <th scope="col" class="t-head-bg">Image</th>
                <th scope="col" class="t-head-bg">Status</th>
                <th scope="col" class="t-head-bg">Action</th>
              </tr>
            </thead>
            <tbody>
            
            @forelse ($tickets as $ticket)
                <tr style="height: 100px;" data-status="{{ $ticket->status ? 'resolved' : 'pending' }}">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $ticket->app_id }}</td>
                    <td>{{ $ticket->name }}</td>
                    <td>{{ $ticket->mobile }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td>{{ $ticket->description }}</td>
                    <td>
                        <img src="{{ asset('storage/'.$ticket->img) }}" width="100" alt="img" onclick="openModal(this.src)">
                    </td>
                    <td>
                        <span 
                            class="badge {{ $ticket->status ? 'bg-paid' : 'bg-pending' }}" 
                            onclick="toggleStatus({{ $ticket->id }}, {{ $ticket->status ? 'false' : 'true' }})" 
                            style="cursor: pointer;"
                        >
                            {{ $ticket->status ? 'Resolved' : 'Pending' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('delete.ticket', $ticket->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger" onclick="return confirm('Are you sure? you want to delete this ticket?')"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center"><h3 class="text-danger py-5">No tickets found!</h3></td>
                </tr>
            @endforelse  
            </tbody>
          </table>


          <p class="fixed-bottom text-center">Powered By ICT Global Tech</p>
    </div>

    <!-- change status -->
    <script>
        function toggleStatus(ticketId, newStatus) {
            fetch(`/tickets/${ticketId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token for security
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the status badge on success
                    const badge = document.querySelector(`span[data-id="${ticketId}"]`);
                    if (newStatus) {
                        badge.classList.remove('bg-pending');
                        badge.classList.add('bg-paid');
                        badge.textContent = 'Resolved';
                    } else {
                        badge.classList.remove('bg-paid');
                        badge.classList.add('bg-pending');
                        badge.textContent = 'Pending';
                    }
                    // Toggle the onclick function to alternate status
                    badge.setAttribute('onclick', `toggleStatus(${ticketId}, ${!newStatus})`);
                }
            })
            .catch(error => console.error('Error:', error));
        }

    </script>

    <script>
        // Function to filter table rows based on search input
        document.getElementById("searchInput").addEventListener("keyup", function () {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll("tbody tr");

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(query)) {
                    row.style.display = ""; // Show row if it matches the query
                } else {
                    row.style.display = "none"; // Hide row if it doesn't match
                }
            });
        });
    </script>

    <script>
        document.getElementById("statusFilter").addEventListener("change", function () {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll("tbody tr");

            rows.forEach(row => {
                const statusBadge = row.querySelector(".badge");

                if (selectedStatus === "all") {
                    row.style.display = ""; // Show all rows
                } else if (
                    (selectedStatus === "pending" && statusBadge.classList.contains("bg-pending")) ||
                    (selectedStatus === "resolved" && statusBadge.classList.contains("bg-paid"))
                ) {
                    row.style.display = ""; // Show row if status matches
                } else {
                    row.style.display = "none"; // Hide row if status doesn't match
                }
            });
        });
    </script>


    <!-- Full-screen image modal -->
    <div id="imageModal" class="image-modal" onclick="closeModal()">
        <span class="close">&times;</span>
        <img class="image-modal-content" id="fullScreenImage">
    </div>
    
    <style>
        .image-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center; /* Center the image */
}

.image-modal-content {
    max-width: 90%; /* Allow the image to take up 90% of the screen width */
    max-height: 90%; /* Allow the image to take up 90% of the screen height */
    margin: auto;
    cursor: zoom-in;
}

.close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

/* Zoom-in and zoom-out on click */
.zoomed {
    transform: scale(1.5);
    cursor: zoom-out;
}

    </style>
  

    <script>
        document.querySelectorAll('.badge').forEach(function(badge) {
            badge.addEventListener('click', function() {
                if (badge.classList.contains('bg-pending')) {
                    badge.classList.remove('bg-pending');
                    badge.classList.add('bg-paid');
                    badge.innerText = 'Resolved';
                } else {
                    badge.classList.remove('bg-paid');
                    badge.classList.add('bg-pending');
                    badge.innerText = 'Pending';
                }
            });
        });
    </script>

<script>
    // Open the modal with the clicked image
    function openModal(imageSrc) {
        const modal = document.getElementById("imageModal");
        const fullScreenImage = document.getElementById("fullScreenImage");

        modal.style.display = "block";
        fullScreenImage.src = imageSrc;
    }

    // Close the modal
    function closeModal() {
        const modal = document.getElementById("imageModal");
        modal.style.display = "none";
        document.getElementById("fullScreenImage").classList.remove("zoomed");
    }

    // Toggle zoom on click
    document.getElementById("fullScreenImage").addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent the click from bubbling up to the modal
        this.classList.toggle("zoomed");
    });
</script>

</body>
</html>