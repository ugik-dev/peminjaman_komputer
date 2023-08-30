$(function () {
	$('[data-toggle="tooltip"]').tooltip();
});

function buttonLoading(btn) {
	if (btn.hasClass("disabled")) {
		return;
	}
	btn.data("original-text", btn.html());
	btn.html(
		'<span class="loading open-circle"></span> ' + btn.data("loading-text")
	);
	btn.addClass("disabled");
}

function buttonIdle(btn) {
	if (!btn.hasClass("disabled")) {
		return;
	}
	btn.html(btn.data("original-text"));
	btn.removeClass("disabled");
}

function swalLoading() {
	swal({
		html: "<h1>Loading ..</h1>",
		// allowOutsideClick: false,
	});
	swal.showLoading();
}

function downloadButton(folder, file, use_nama = true) {
	if (file)
		return `<a class="btn btn-success btn-xs btn-download" href="${folder}${file}"><i class='fa fa-download'></i> ${
			use_nama ? file : "Download"
		}</a>`;
	return `Tidak Ada`;
}

function downloadButtonEn(folder, file, use_nama = true) {
	if (file)
		return `<a class="btn btn-success btn-xs btn-download" href="${folder}${file}"><i class='fa fa-download'></i> ${
			use_nama ? file : "Download"
		}</a>`;
	return `Not Complete`;
}

function downloadButtonV2(folder, file, override_nama) {
	if (file)
		return `<a class="btn btn-success btn-xs btn-download" href="${folder}${file}"><i class='fa fa-download'></i> ${
			override_nama ? override_nama : file
		}</a>`;
	return `Tidak Ada`;
}

function arrayToAssociative(arr, key) {
	ret = [];

	if (data == null || !Array.isArray(data) || data.length == 0) {
		console.log("EMPTY ARRAY");
		return ret;
	}

	if (data[0][key] === undefined) {
		console.log("KEY NOT EXIST");
		return ret;
	}

	arr.forEach((e) => {
		ret[e[key]] = e;
	});

	return ret;
}

function capFirstLetter(str) {
	return str
		.split(" ")
		.map((str) => str[0].toUpperCase() + str.slice(1).toLowerCase())
		.reduce((acc, curr) => acc + curr + " ", "")
		.slice(0, -1);
}

function intToDay(val) {
	switch (val) {
		case 0:
			return "Minggu";
		case 1:
			return "Senin";
		case 2:
			return "Selasa";
		case 3:
			return "Rabu";
		case 4:
			return "Kamis";
		case 5:
			return "Jum'at";
		case 6:
			return "Sabtu";
	}
}

function statusData(val) {
	if (val == 0)
		return '<span class="badge badge-secondary">Belum input data</span>';
	else if (val == 1)
		return '<span class="badge badge-primary">Menunggu Verifikasi</span>';
	else if (val == 2)
		return '<span class="badge badge-success">Diverifikasi</span>';
	else if (val == 3) return '<span class="badge badge-danger">Ditolak</span>';
	else return '<span class="badge badge-secondary">Belum input data</span>';
}

function empty(str) {
	if (str == null || str.trim() == "") {
		return true;
	} else {
		return false;
	}
}

MONTHS = [
	"Januari",
	"Februari",
	"Maret",
	"April",
	"Mei",
	"Juni",
	"Juli",
	"Agustus",
	"September",
	"Oktober",
	"November",
	"Desember",
];

function renderDate(date) {
	return `${date.getDate()} ${MONTHS[date.getMonth()]} ${date.getFullYear()}`;
}

function findAssociative(arr, field, value) {
	for (var key in arr) {
		var v = arr[key];
		if (v[field] && v[field] == value) {
			return v;
		}
	}
	return null;
}

function filterAssociative(arr, field, value) {
	var ret = [];
	for (var key in arr) {
		var v = arr[key];
		if (v[field] && v[field] == value) {
			ret.push(v);
		}
	}
	return ret;
}

function convertToRupiah(angka) {
	var rupiah = "";
	var angkarev = angka.toString().split("").reverse().join("");
	for (var i = 0; i < angkarev.length; i++) {
		if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ",";
	}
	rupiah = rupiah
		.split("", rupiah.length - 1)
		.reverse()
		.join("");
	return rupiah.length < 1 ? "0" : rupiah;
}
