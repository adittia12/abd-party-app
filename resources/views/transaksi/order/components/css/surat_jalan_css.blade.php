<style>
    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 250px;
        transform: translate(-50%, -50%);
        opacity: 0.2;
        z-index: -1;
    }

    @page {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .page-break {
        page-break-before: always;
    }

    .table-id {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
        font-size: 12px;
        font-family: Arial, sans-serif;
        min-width: 400px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    .table-id thead tr {
        background-color: #00987a3d;
        color: #000000;
        text-align: left;
        font-weight: bold;
    }

    .table-id th,
    .table-id td {
        padding: 3px 7px;
        /* Mengurangi padding untuk mengurangi tinggi */
        border: 1px solid #ddd;
        text-align: left;
        height: 1px;
        /* Mengurangi height */
    }

    .table-id tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .table-id tbody tr:nth-of-type(even) {
        background-color: #f3f3f35c;
    }

    .table-id tbody tr:last-of-type {
        border-bottom: 2px solid #00987a69;
    }

    .table-id tfoot {
        background-color: #f3f3f36b;
        font-weight: bold;
    }

    .table-id tfoot .text-right {
        text-align: right;
    }

    .text-signature {
        font-size: 13px;
        text-align: center;
    }

    .text-info-jalan {
        font-size: 13px;
    }
</style>
