<style>
    <?php 
        require_once('./CSS/statistic-profit.css');
    ?>
</style>

<?php
    ?>
        <div class="statistic-profit-container">
            <!-- Statistic profit processing -->
            <div class="statistic-profit-title">Thống kê doanh thu</div>

            <!-- Profits list -->
            <div class="profits-list">
                <table>
                    <tr>
                        <th>STT</th>
                        <th>Ngày</th>
                        <th>Doanh thu trong ngày</th>
                    </tr>

                    <!-- Get profits list data -->
                    <?php
                        $db = getDatabase();
                        $profitsData = getProfits($db);
                        $totalProfit = 0;

                        if ($profitsData != null && $profitsData -> num_rows > 0) {
                            $number = 0;

                            while ($data = $profitsData -> fetch_assoc()) {
                                $paymentId = $data['payment_id'];

                                // Get payment data by id
                                $paymentDetail = getPaymentById($paymentId);
                                $paymentData = $paymentDetail -> fetch_assoc();
                                $totalCost = $paymentData['total_cost'];
                                $paymentDate = $paymentData['payment_date'];

                                // Add to total profit
                                $totalProfit += $totalCost;

                                ?>
                                    <tr>
                                        <td><?= $number += 1 ?></td>
                                        <td><?= $paymentDate ?></td>
                                        <td><?= number_format($totalCost) ?></td>
                                    </tr>
                                <?php
                            }
                        }
                    ?>
                </table>
            </div>

            <?php
                if ($totalProfit != 0) {
                    ?>
                        <!-- Display total profits -->
                        <div class="total-profit">Tổng doanh thu của sân bóng: <span><?= number_format($totalProfit) ?></span></div>
                    <?php
                }

                else {
                    ?>
                        <!-- Display total profits -->
                        <div class="total-profit">Tổng doanh thu của sân bóng: <span>0đ</span></div>
                    <?php
                }
            ?>
        </div>
    <?php
?>