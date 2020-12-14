 <!-- Control Sidebar -->
 <aside class="control-sidebar control-sidebar-dark">
   <!-- Control sidebar content goes here -->
 </aside>
 <!-- /.control-sidebar -->
 <!-- Main Footer -->
 <footer class="main-footer">
   <strong>Copyright &copy;<script type="text/javascript">
       document.write(new Date().getFullYear());
     </script> <a href="#"><?php echo BRAND_NAME ?></a>.</strong> All rights reserved.
   <div class="float-right d-none d-sm-inline-block">
     <b>Developed by </b><a href="https://www.gennextit.com/" target="_blank"><?php echo 'GennextIT'; ?></a>
   </div>
 </footer>
 </div>
 <!-- ./wrapper -->

 <!-- REQUIRED SCRIPTS -->

 <!-- Bootstrap -->
 <script src="<?php echo base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!-- overlayScrollbars -->
 <script src="<?php echo base_url('assets/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
 <!-- AdminLTE App -->
 <script src="<?php echo base_url('assets/') ?>dist/js/adminlte.js"></script>

 <!-- PAGE PLUGINS -->
 <!-- jQuery Mapael -->
 <script src="<?php echo base_url('assets/') ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/raphael/raphael.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
 <!-- ChartJS -->
 <script src="<?php echo base_url('assets/') ?>plugins/chart.js/Chart.min.js"></script>

 <!-- AdminLTE for demo purposes -->
 <script src="<?php echo base_url('assets/') ?>dist/js/demo.js"></script>

 <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
 <!-- <script src="<?php echo base_url('assets/') ?>dist/js/pages/dashboard2.js"></script> -->


 <!-- DataTables  & Plugins -->
 <script src="<?php echo base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/jszip/jszip.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/pdfmake/pdfmake.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/pdfmake/vfs_fonts.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
 <script src="<?php echo base_url('assets/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
 <!-- SweetAlert2 -->
 <!-- <script src="<?php echo base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.js"></script> -->
 <!-- custom -->
 <script src="<?php echo base_url('assets/custom/js/addData.js') ?>"></script>
 <!-- Select2 -->
 <script src="<?php echo base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
 <script src="<?php echo base_url() ?>assets/plugins/toastr/toastr.min.js"></script>

 <!-- lib -->
 <script src="<?php echo base_url() ?>assets/custom/js/lib.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
 <script>
   $(function() {

     $('#role-master').dataTable({
       columnDefs: [{
           width: "5%",
           targets: 0
         },
         {
           width: "20%",
           targets: [1, 2]
         },
       ],
       fixedColumns: true,
       fixedHeader: {
         header: false,
         footer: false
       },

     });

     $('.datepicker').datepicker({
       todayBtn: "linked",
       format: "dd/mm/yyyy",
      //  keyboardNavigation: false,
      //  forceParse: false,
       calendarWeeks: true,
       autoclose: true,
       
     });

     $('.dataTable').DataTable();

   });

   $(function() {
     //Initialize Select2 Elements
     $('.select2').select2();
   });


   $(function() {
     $('body').on('focus', ".datepicker", function() {
       $(this).datepicker({
         todayBtn: "linked",
         language: "EN",
         autoclose: true,
         todayHighlight: true,
         format: 'dd/mm/yyyy',
         showButtonPanel: true,
         localToday: localToday
       });
     });

   });
 </script>
 </body>

 </html>