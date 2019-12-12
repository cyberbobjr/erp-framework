function dateFormater(value) {
    return moment(value).format("DD/MM/YYYY");
}

/**
 * Formatter pour le composant EasyUI Table
 * @param value
 * @returns {string}
 */
function etatFormater(value) {
    if (value) {
        var classe = 'success';
        var msg = '';
        if (value.paye) {
            classe = 'success';
            msg = 'Payé';
        } else if (value.payable) {
            classe = 'danger';
            msg = 'Impayé';
        } else if (value.cloture) {
            classe = 'default';
            msg = 'Clôturé';
        } else {
            classe = 'info';
            msg = 'Brouillon';
        }
        return '<span class="label label-' + classe + ' label-mini">' + msg + '</span>';
    }
}

/**
 * Formatter pour le composant bootstrapTable
 * @param value
 * @returns {string}
 */
function etatBTFormatter(value) {
    if (!value) {
        return;
    }
    var classe = "";
    if (value["state"] === 1) {
        classe = "default";
    } else if (value["state"] === 4) {
        classe = 'info';
    } else if (value["solde"] > 0 && value["total_ttc"] === value["solde"]) {
        classe = "danger";
    } else if (value["solde"] > 0) {
        classe = "warning";
    } else {
        classe = "success";
    }
    return classe;
}

function sensFormater(value) {
    if (value === 1) {
        return '<div class="alert-danger"><span class="glyphicon glyphicon-arrow-left danger"></span></div>';
    }
    return '<div class="alert-success"><span class="glyphicon glyphicon-arrow-right success"></span></div>';
}

function senspaiementFormater(value) {
    if (value === 2) {
        return '<div class="alert-danger"><span class="glyphicon glyphicon-arrow-left danger"></span></div>';
    }
    return '<div class="alert-success"><span class="glyphicon glyphicon-arrow-right success"></span></div>';
}

function boolFormater(value) {
    if (value) {
        return '<span class="label label-success label-mini">oui</span>';
    }
    return '<span class="label label-danger label-mini">non</span>';
}

function comptaFormater(value) {
    if (value === 1) {
        return '<span class="label label-success label-mini">au débit</span>';
    }
    return '<span class="label label-danger label-mini">au crédit</span>';
}

function currencyFormater(value) {
    if (!value) {
        return "0,00€";
    }
    var result = parseFloat(value).toFixed(2);
    return (result.toString().replace(/\./g, ',') + "€");
}

function queryParams() {
    return {
        type: 'owner',
        sort: 'updated',
        direction: 'desc',
        per_page: 100,
        page: 1
    };
}