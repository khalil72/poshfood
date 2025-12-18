<?php
date_default_timezone_set('Asia/Karachi');

$cutoff = new DateTime('+1 day 23 hours 1 minute 4 seconds');
$now = new DateTime();
$diff = $cutoff->diff($now);

$time_remaining = sprintf(
    '%dd %02dh %02dm %02ds',
    $diff->d,
    $diff->h,
    $diff->i,
    $diff->s
);
?>

<section class="next-order-cutoff py-2 pb-2" style="background: #fff;">
    <div class="container d-flex flex-column flex-md-row justify-content-center align-items-center gap-4">
        
        <div>
            <h5 class="mb-0  ">Next Order :</h5>
        </div>

        <div>
            <h6 class="mb-0 text-success" id="countdown"><?php echo $time_remaining; ?></h6>
        </div>

       
        <div class="mx-3">
            <a href="order.php" class="btn btn-primary btn-sm">Order Now</a>
        </div>
    </div>
</section>

<!-- JS Countdown -->
<script>
let countdownEl = document.getElementById('countdown');
let phpCountdown = <?php echo $diff->days * 86400 + $diff->h * 3600 + $diff->i * 60 + $diff->s; ?>;

function updateCountdown() {
    if(phpCountdown <= 0) return;

    phpCountdown--;

    let days = Math.floor(phpCountdown / 86400);
    let hours = Math.floor((phpCountdown % 86400) / 3600);
    let minutes = Math.floor((phpCountdown % 3600) / 60);
    let seconds = phpCountdown % 60;

    countdownEl.innerText = `${days}d ${hours.toString().padStart(2,'0')}h ${minutes.toString().padStart(2,'0')}m ${seconds.toString().padStart(2,'0')}s`;
}

setInterval(updateCountdown, 1000);
</script>
