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

    .container-invoice {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 5px 10px;
        font-family: Arial, sans-serif;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin: 5px 0;
    }

    .left,
    .right {
        flex: 1;
        margin: 0 10px;
    }

    .right {
        text-align: right;
    }

    h5 {
        margin-bottom: 3px;
    }

    p {
        margin: 0;
        padding: 0;
        font-size: 14px;
    }

    .text-secondary {
        color: #6c757d;
    }

    .section-header {
        display: flex;
        justify-content: flex-start;
        padding: 5px 10px;
        /* Mengurangi padding atas */
        font-family: Arial, sans-serif;
        margin: 5px 0;
        /* Mengurangi margin atas */
    }

    .header-content {
        font-size: 10px;
    }

    .header-content img {
        width: 250px;
    }

    .header-content p {
        margin: 0;
        padding: 0;
    }

    .header-content a {
        color: #007bff;
        text-decoration: none;
    }

    .header-content a:hover {
        text-decoration: underline;
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

    .container-signature {
        display: flex;
        justify-content: space-between;
        /* Ensure equal spacing between elements */
        align-items: center;
        /* Align items to the center vertically */
        margin-top: 20px;
    }

    .bank-info,
    .signature {
        flex: 1;
    }

    .card-bank {
        background: #e8e8e88c;
        padding: 10px;
        width: 250px;
        font-size: 10px;
        /* Reduce font size */
    }

    .text-bank {
        color: #6c757d;
    }

    .send-info {
        font-size: 10px;
    }

    .signature-content {
        text-align: center;
    }

    .signature {
        text-align: center;
    }
</style>
