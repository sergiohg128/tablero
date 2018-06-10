function getTable(number_table) {
	var tables = initTable();
	// perform API operations with `table`
	let table = tables.context[number_table];
	if (typeof table === 'undefined') {
		return "Tabla no existe";
	}
	return table;
}

function getColumns(indexes) {
	if (Array.isArray(indexes)) {
		for (let el of indexes) {
			if (!Number.isInteger(el) || el < 0) {
				return "Array de columnas no válido.";
			}
		}
		return indexes;
	} else {
		return "Valor no válido";
	}
}

function getOptions(array){
	if (Array.isArray(array)) {
		if (array.length > 2) {
			return "Cantidad de opciones mayor a lo esperado."
		}
		for (let el of array) {
			if (el !== 'no_sortable' && el !== 'no_searchable') {
				return "Array de opciones no válido.";
			}
		}
		return array;
	} else {
		return "Valor no válido.";
	}
}

function noSortableTable(number_table, columns) {
	table = getTable(number_table);
	if (typeof table === 'string') { return table; }
	if (typeof getColumns(columns) === 'string') { return getColumns(columns); }

	for (let col of columns) {
		let columna = table.aoColumns[col];
		let data = table.aoData;
		columna.bSortable = false;
		columna.nTh.className = "";
		columna.sSortingClass = "";
	}
}