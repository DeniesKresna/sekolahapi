<div class="wrap">
    <h1>Draft <strong>Countdown</strong></h1>

    <div class="countdown">
        <div class="bloc-time hours" data-init-value="24">
            <span class="count-title">Hours</span>

            <div class="figure hours hours-1">
                <span class="top">2</span>
                <span class="top-back">
          <span>2</span>
        </span>
                <span class="bottom">2</span>
                <span class="bottom-back">
          <span>2</span>
        </span>
            </div>

            <div class="figure hours hours-2">
                <span class="top">4</span>
                <span class="top-back">
          <span>4</span>
        </span>
                <span class="bottom">4</span>
                <span class="bottom-back">
          <span>4</span>
        </span>
            </div>
        </div>

        <div class="bloc-time min" data-init-value="0">
            <span class="count-title">Minutes</span>

            <div class="figure min min-1">
                <span class="top">0</span>
                <span class="top-back">
          <span>0</span>
        </span>
                <span class="bottom">0</span>
                <span class="bottom-back">
          <span>0</span>
        </span>
            </div>

            <div class="figure min min-2">
                <span class="top">0</span>
                <span class="top-back">
          <span>0</span>
        </span>
                <span class="bottom">0</span>
                <span class="bottom-back">
          <span>0</span>
        </span>
            </div>
        </div>

        <div class="bloc-time sec" data-init-value="0">
            <span class="count-title">Seconds</span>

            <div class="figure sec sec-1">
                <span class="top">0</span>
                <span class="top-back">
          <span>0</span>
        </span>
                <span class="bottom">0</span>
                <span class="bottom-back">
          <span>0</span>
        </span>
            </div>

            <div class="figure sec sec-2">
                <span class="top">0</span>
                <span class="top-back">
          <span>0</span>
        </span>
                <span class="bottom">0</span>
                <span class="bottom-back">
          <span>0</span>
        </span>
            </div>
        </div>
    </div>
</div>

<style>

    .wrap {
        position: absolute;
        bottom: 0;
        top: 0;
        left: 0;
        right: 0;
        margin: auto;
        height: 310px;
    }

    a {
        text-decoration: none;
        color: #1a1a1a;
    }

    $lato: 'Lato';

       h1 {
           margin-bottom: 60px;
           text-align: center;
           font: 300 0.7em SansSerif;
           text-transform: uppercase;

    strong {
        font-weight: 400;
        color: #ea4c4c;
    }
    }

    h2 {
        margin-bottom: 80px;
        text-align: center;
        font: 300 0.7em SansSerif;
        text-transform: uppercase;

    strong {
        font-weight: 400;
    }
    }

       .countdown {
           width: 720px;
           margin: 0 auto;

    .bloc-time {
        float: left;
        margin-right: 45px;
        text-align: center;

    &:last-child {
         margin-right: 0;
     }
    }

    .count-title {
        display: block;
        margin-bottom: 15px;
        font: normal 0.94em $lato;
        color: #1a1a1a;
        text-transform: uppercase;
    }

    .figure {
        position: relative;
        float: left;
        height: 110px;
        width: 100px;
        margin-right: 10px;
        background-color: #fff;
        border-radius: 8px;
    @include box-shadow(0 3px 4px 0 rgba(0, 0, 0, .2),inset 2px 4px 0 0 rgba(255, 255, 255, .08));

    &:last-child {
         margin-right: 0;
     }

    >span {
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        font: normal 5.94em/107px $lato;
        font-weight: 700;
        color: #de4848;
    }

    .top, .bottom-back {
    &:after {
         content: "";
         position: absolute;
         z-index: -1;
         left: 0;
         bottom: 0;
         width: 100%;
         height: 100%;
         border-bottom: 1px solid rgba(0, 0, 0, .1);
     }
    }

    .top {
        z-index: 3;
        background-color: #f7f7f7;
        transform-origin: 50% 100%;
        -webkit-transform-origin: 50% 100%;
    @include border-top-radius(10px);
    @include transform(perspective(200px));
    }

    .bottom {
        z-index: 1;

    &:before {
         content: "";
         position: absolute;
         display: block;
         top: 0;
         left: 0;
         width: 100%;
         height: 50%;
         background-color: rgba(0, 0, 0, .02);
     }
    }

    .bottom-back {
        z-index: 2;
        top: 0;
        height: 50%;
        overflow: hidden;
        background-color: #f7f7f7;
    @include border-top-radius(10px);

    span {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        margin: auto;
    }
    }

    .top, .top-back {
        height: 50%;
        overflow: hidden;
    @include backface-visibility(hidden);
    }

    .top-back {
        z-index: 4;
        bottom: 0;
        background-color: #fff;
        -webkit-transform-origin: 50% 0;
        transform-origin: 50% 0;
    span {
        position: absolute;
        top: -100%;
        left: 0;
        right: 0;
        margin: auto;
    }
    }
    }
    }

</style>