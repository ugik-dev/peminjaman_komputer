<!-- <br>
<br>
<div class="footer" style="position:fixed">
	<div class="float-right">
		DEMO SMA NEGERI 1 SUNGAILIAT
	</div>
	<div>
		<strong>Copyright</strong> &copy; 2020 || cc : ugik.dev@gmail.com || +62 812 7974 8967
	</div>
</div> -->
<!-- </div> -->


<!-- <script type="text/javascript">
	$(document).ready(function() {
		$('#tmtdate .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			calendarWeeks: true,
			format: "yyyy-mm-dd"
		});
		$('#tmtdate2 .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			calendarWeeks: true,
			format: "yyyy-mm-dd"
		});
	});
</script> -->


<!-- Mainly scripts -->
<script src="<?= base_url('assets/') ?>js/popper.min.js"></script>
<script src="<?= base_url('assets/') ?>js/bootstrap.js"></script>
<script src="<?= base_url('assets/') ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= base_url('assets/') ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="https://use.fontawesome.com/8d0f67fd10.js"></script>
<!-- Date Picker-->
<script src="<?php echo base_url('assets'); ?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url('assets/') ?>js/inspinia.js"></script>
<script src="<?= base_url('assets/') ?>js/plugins/pace/pace.min.js"></script>

<script src="<?= base_url('assets/') ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url('assets'); ?>/js/plugins/jquery-autocomplete.js"></script>

<script>
    <?= $this->session->flashdata('msg') ?>
</script>
</body>

</html>