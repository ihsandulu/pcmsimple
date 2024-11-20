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

	function openInNewWindow(event) {
        event.preventDefault();
        
        // Membuka jendela baru
        const form = event.target;
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();
        
        // URL dengan parameter
        const url = form.action + "?" + params;
        
        // Buka sebagai jendela baru dan simpan referensi "opener"
        window.open(url, "_blank");
    }

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
    const scrollableTable = document.querySelector('.tarik');

    let isDragging = false;
    let startX, scrollLeft;

    scrollableTable.addEventListener('mousedown', (e) => {
        isDragging = true;
        scrollableTable.classList.add('dragging');
        startX = e.pageX - scrollableTable.offsetLeft;
        scrollLeft = scrollableTable.scrollLeft;
    });

    scrollableTable.addEventListener('mouseleave', () => {
        isDragging = false;
        scrollableTable.classList.remove('dragging');
    });

    scrollableTable.addEventListener('mouseup', () => {
        isDragging = false;
        scrollableTable.classList.remove('dragging');
    });

    scrollableTable.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - scrollableTable.offsetLeft;
        const walk = (x - startX) * 2; // Adjust scrolling speed
        scrollableTable.scrollLeft = scrollLeft - walk;
    });
</script>
