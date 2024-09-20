<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>WhatsApp CRM</title>
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/02RpgdM2/whatsapp3d.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/css/ready.css">
    <link rel="stylesheet" href="assets/css/demo.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    @extends('layout.app')

    @section('content')
    <div class="main-panel">
        <div class="content pb-0">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                        <p class="mb-0">{{ session('success') }}</p>
                        <a type="button" class="" data-bs-dismiss="alert" aria-label="Close" style="cursor:pointer; color:#fff;">X</a>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12 mb-0">
                        <div class="card p-4" style="border-radius: 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0" data-toggle="modal" data-target="#messagingLimit"><i class="fa-solid fa-ticket"></i> <b>Support Ticket</b></h4>
                                    <hr class="m-2">
                                    <p class="mb-0 text-secondary">When customers have problem, they open Support tickets</p>
                                </div>
                                <div>
                                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#openTicket" style="border-radius: 40px;"><b>Open a Ticket</b> &nbsp;<i class="fa-solid fa-ticket"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
    @endsection
</body>


<!-- Modal -->
<div class="modal fade" id="openTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius:20px !important;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><b>Open a Ticket</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
            <label for=""></label>
            <input type="text" class="form-control" name="" id="">
        </div>
      </div>
    </div>
  </div>
</div>


<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chartist/chartist.min.js"></script>
<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
<script src="assets/js/demo.js"></script>
</html>
