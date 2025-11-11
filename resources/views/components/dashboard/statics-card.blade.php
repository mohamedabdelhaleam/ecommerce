@props(['title', 'value', 'percentage', 'percentageText', 'icon'])
<div class="col-xxl-3 col-sm-6  col-ssm-12 mb-25">
    <div class="ap-po-details ap-po-details--luodcy  overview-card-shape radius-xl d-flex justify-content-between">
        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between w-100">
            <div class="ap-po-details__titlebar">
                <p>{{ $title }}</p>
                <h1>{{ $value }}</h1>
                <div class="ap-po-details-time">
                    <span class="color-success"><i class="las la-arrow-up"></i>
                        <strong>{{ $percentage }}</strong></span>
                    <small>{{ $percentageText }}</small>
                </div>
            </div>
            <div class="ap-po-details__icon-area color-primary">
                {!! $icon !!}
            </div>
        </div>

    </div>
</div>
