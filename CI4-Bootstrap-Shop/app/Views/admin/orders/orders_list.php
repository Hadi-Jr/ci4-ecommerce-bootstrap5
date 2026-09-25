<!-- ADMIN ORDERS LIST START -->
<h1 class="h3 mb-3"><strong>Orders</strong> Table</h1>

<div class="row justify-content-center mb-5">
    <div class="card shadow border-0 table-responsive">
        <table id="ordersTable" class="table">
            <thead>
            <tr>
                <th scope="col">Details</th>
                <th scope="col">Client</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Nr.</th>
                <th scope="col">TRK Nr.</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Order Date</th>
                <th scope="col">Delivery Date</th>
                <th scope="col">Delivered At</th>
                <th scope="col">Notes</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
            foreach ($orders as $order) {
                ?>
                <tr>
                    <td>
                        <button data-id="<?= $order->id ?>" class="btn btn-primary btn-sm view-order-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    <td><?= $order->full_name ?></td>
                    <td><?= $order->email_address?></td>
                    <td><?= $order->phone_number?></td>
                    <td><?= $order->tracking_number?></td>
                    <td><?= ucwords($order->payment_method) ?></td>
                    <td>$<?= number_format($order->total_amount, 2) ?></td>
                    <td>
                        <?php
                        $cls_status = 'success';
                        if ($order->status === 'cancelled') {
                            $cls_status = 'danger';
                        } else if ($order->status === 'pending') {
                            $cls_status = 'warning';
                        }
                        ?>
                        <div class="dropdown" id="status">
                            <button style="width: 90px" class="btn btn-<?= $cls_status ?> dropdown-toggle btn-sm"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <?= ucwords($order->status) ?>
                            </button>
                            <ul class="dropdown-menu" data-id="<?= $order->id ?>">
                                <li><a data-status="Cancelled" class="dropdown-item" href="#">Cancelled</a></li>
                                <li><a data-status="Delivered" class="dropdown-item" href="#">Delivered</a></li>
                                <li><a data-status="Pending" class="dropdown-item" href="#">Pending</a></li>
                            </ul>
                        </div>
                    </td>
                    <td><?= $order->order_date ?></td>
                    <td><?= $order->delivery_time ?></td>
                    <td><?= $order->delivered_at ?? '-'?></td>
                    <td>
                        <button style="width: 55px" <?= $order->notes ? '' : 'disabled' ?>
                                data-notes="<?= $order->notes ?>"
                                class="p-1 btn btn-<?= $order->notes ? 'info' : 'danger' ?> btn-sm notes-btn">
                            <?= $order->notes ? 'View' : 'Empty' ?>
                        </button>
                    </td>
                </tr>
                <!-- Order Details Modal -->
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
            if ($total_pages > 1) {
                $visible_pages = 5;
                $start_page = max(1, $current_page - 2);
                $end_page = min($total_pages, $start_page + $visible_pages - 1);

                if (($end_page - $start_page + 1) < $visible_pages) {
                    $start_page = max(1, $end_page - $visible_pages + 1);
                }
                ?>
                <div class="row mb-2">
                    <div class="col-12 text-end">
                        <a class="btn" href="<?= base_url('/admin/orders-list') . '?page=1' ?>">«</a>
                        <a class="btn" href="<?= base_url('/admin/orders-list') . '?page=' . max(1, $current_page - 1)?>">‹</a>
                        <?php
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            ?>
                            <a class="btn"
                               href="<?= base_url('/admin/orders-list') . '?page=' . $i?>"><?= $i ?></a>
                        <?php
                        }
                        ?>
                        <a class="btn" href="<?= base_url('/admin/orders-list') . '?page=' . min($total_pages, $current_page + 1) ?>">›</a>
                        <a class="btn" href="<?= base_url('/admin/orders-list') . '?page=' . $total_pages ?>">»</a>
                    </div>
                </div>
            <?php
        }
        ?>
    </div>
</div>

<script>
    $('.notes-btn').on('click', function () {
        const notes = $(this).data('notes');
        Swal.fire({
            title: "Notes from Customer",
            html: `
                <div class="mt-2 text-start">
                    ${notes}
                </div>
              `,
            showCancelButton: true,
            cancelButtonText: "Close",
            showConfirmButton: false
        });
    });

    $('#status .dropdown-item').on('click', function (e) {
        e.preventDefault();

        let order_id = $(this).closest('.dropdown-menu').data('id');
        let status = $(this).data('status');

        Swal.fire({
            title: "Do you want change the status of this order ?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/change-order-status') ?>',
                    method: 'post',
                    data: {
                        order_id: order_id,
                        status: status
                    },
                    dataType: 'json'
                }).done(function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Status Updated!",
                            text: response.message,
                            icon: "success",
                            confirmButtonColor: "#46c82c",
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            title: "Request failed!",
                            text: response.message,
                            icon: "error",
                            confirmButtonColor: "#46c82c",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                });
            }
        });
    });

    $('.view-order-btn').on('click', function (e) {
        e.preventDefault();
        const order_id = $(this).data('id');

        $.ajax({
            url: '<?= base_url('/admin/order_detail/') ?>' + order_id,
            method: 'GET',
        }).done(function (response) {
            Swal.fire({
                title: 'Order Details',
                html: response,
                width: 1000,
                showCloseButton: true,
                showConfirmButton: false
            });
        });
    });
</script>
