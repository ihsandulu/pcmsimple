<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
	$(document).ready(function() {
		$('[data-toggle="popover"]').popover();
	});

	$(function() {
		$(".date").datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true
		});
		$('.select2').select2({
			placeholder: 'Pilih Opsi',
			allowClear: true
		});
	});

	function confirmDelete(id) {
		const isConfirmed = confirm("Continue Delete?");
		if (isConfirmed) {
			$("#" + id).attr("type", "submit").attr("onclick", "").click();
		} else {
			return false;
		}
	}

	! function($) {
		$(document).on("click", "ul.nav li.parent > a > span.icon", function() {
			$(this).find('em:first').toggleClass("glyphicon-minus");
		});
		$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
	}(window.jQuery);

	$(window).on('resize', function() {
		if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
	})
	$(window).on('resize', function() {
		if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
	})

	function bukaproduk(url) {
		window.open(url, '_blank');
	}

	function tutup() {
		if (window.opener) {
			window.opener.location.href = window.opener.location.href;
			setTimeout(() => window.close(), 500); // Tunggu 500 ms sebelum menutup
		} else {
			alert('Tidak dapat menemukan halaman opener.');
		}
	}

	function kembali() {
		window.location.href = window.location.href;
	}

	function tampilimg(a) {
		$("#imgumum").attr('src', $(a).attr('src'));
		$("#myImage").modal();
	}


	$(function() {
		$("#dataTable").draggable({
			axis: "x",
			containment: "parent"
		});
		$("#dataTable1").draggable({
			axis: "x",
			containment: "parent"
		});
	});
</script>

<script>
	// tarik
	const tableContainer = document.querySelector('.tarik');

	let isDown = false;
	let startX;
	let scrollLeft;

	tableContainer.addEventListener('mousedown', (e) => {
		isDown = true;
		tableContainer.classList.add('active');
		startX = e.pageX - tableContainer.offsetLeft;
		scrollLeft = tableContainer.scrollLeft;
	});

	tableContainer.addEventListener('mouseleave', () => {
		isDown = false;
		tableContainer.classList.remove('active');
	});

	tableContainer.addEventListener('mouseup', () => {
		isDown = false;
		tableContainer.classList.remove('active');
	});

	tableContainer.addEventListener('mousemove', (e) => {
		if (!isDown) return;
		e.preventDefault();
		const x = e.pageX - tableContainer.offsetLeft;
		const walk = (x - startX) * 2; // Nilai 2 bisa diatur untuk kecepatan scroll
		tableContainer.scrollLeft = scrollLeft - walk;
	});
</script>