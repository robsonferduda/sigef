"use strict";
var Datatables = function() {

	var initTable = function() {
		var table = $('#datatable');

		table.DataTable({
			responsive: true,
			pagingType: 'full_numbers',
			searching: false,
			paging: false 
		});
	};

	return {

		init: function() {
			initTable();
		},

	};

}();

jQuery(document).ready(function() {
	Datatables.init();
});