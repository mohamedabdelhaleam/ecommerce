@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <x-dashboard.statics-card title="Total Products" value="100+" percentage="25.36%" percentageText="Since last month"
            icon="<i class='uil uil-box'></i>" />
        <x-dashboard.statics-card title="Total Orders" value="100+" percentage="25.36%" percentageText="Since last month"
            icon="<i class='uil uil-shopping-cart'></i>" />
        <x-dashboard.statics-card title="Total Customers" value="100+" percentage="25.36%"
            percentageText="Since last month" icon="<i class='uil uil-users-alt'></i>" />
        <x-dashboard.statics-card title="Total Revenue" value="100+" percentage="25.36%" percentageText="Since last month"
            icon="<i class='uil uil-money-bill'></i>" />

    </div>
    <div class="row">
        <div class="col-xxl-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Products Chart
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="clientBasic"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 mb-4">
            <div class="card border-0 px-25" style="height: 100% !important ;">
                <div class="card-header px-0 border-0">
                    <h6>New Product</h6>
                    
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="t_selling-today" role="tabpanel"
                            aria-labelledby="t_selling-today-tab">
                            <div class="selling-table-wrap">
                                <div class="table-responsive">
                                    <table class="table table--default table-borderless ">
                                        <thead>
                                            <tr>
                                                <th>PRDUCTS NAME</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="radius-xs img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/giorgio.png"
                                                            alt="img">
                                                        <span>UV Protected Sunglass</span>
                                                    </div>
                                                </td>
                                                <td>$38,536</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="radius-xs img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/headphone.png"
                                                            alt="img">
                                                        <span>Black Headphone</span>
                                                    </div>
                                                </td>
                                                <td>$20,573</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="radius-xs img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/shoes.png"
                                                            alt="img">
                                                        <span>Nike Shoes</span>
                                                    </div>
                                                </td>
                                                <td>$17,457</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="radius-xs img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/mac-pro.png"
                                                            alt="img">
                                                        <span>15" Mackbook Pro</span>
                                                    </div>
                                                </td>
                                                <td>$15,354</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="radius-xs img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/creativ-bag.png"
                                                            alt="img">
                                                        <span>Women Bag</span>
                                                    </div>
                                                </td>
                                                <td>$12,354</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="t_selling-week" role="tabpanel" aria-labelledby="t_selling-week-tab">
                            <div class="selling-table-wrap">
                                <div class="table-responsive">
                                    <table class="table table--default table-borderless">
                                        <thead>
                                            <tr>
                                                <th>PRDUCTS NAME</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/287.png" alt="img">
                                                        <span>Samsung Galaxy S8 256GB</span>
                                                    </div>
                                                </td>
                                                <td>$60,258</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid"
                                                            src="http://45.33.34.15:8002/assets/img/165.png" alt="img">
                                                        <span>Half Sleeve Shirt</span>
                                                    </div>
                                                </td>
                                                <td>$2,483</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/166.png" alt="img">
                                                        <span>Marco Shoes</span>
                                                    </div>
                                                </td>
                                                <td>$19,758</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/315.png"
                                                            alt="img">
                                                        <span>15" Mackbook Pro</span>
                                                    </div>
                                                </td>
                                                <td>$197,458</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/506.png"
                                                            alt="img">
                                                        <span>Apple iPhone X</span>
                                                    </div>
                                                </td>
                                                <td>115,254</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="t_selling-month" role="tabpanel"
                            aria-labelledby="t_selling-month-tab">
                            <div class="selling-table-wrap">
                                <div class="table-responsive">
                                    <table class="table table--default table-borderless">
                                        <thead>
                                            <tr>
                                                <th>PRDUCTS NAME</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/287.png"
                                                            alt="img">
                                                        <span>Samsung Galaxy S8 256GB</span>
                                                    </div>
                                                </td>
                                                <td>$60,258</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid"
                                                            src="http://45.33.34.15:8002/assets/img/165.png"
                                                            alt="img">
                                                        <span>Half Sleeve Shirt</span>
                                                    </div>
                                                </td>
                                                <td>$2,483</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/166.png"
                                                            alt="img">
                                                        <span>Marco Shoes</span>
                                                    </div>
                                                </td>
                                                <td>$19,758</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/315.png"
                                                            alt="img">
                                                        <span>15" Mackbook Pro</span>
                                                    </div>
                                                </td>
                                                <td>$197,458</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="selling-product-img d-flex align-items-center">
                                                        <img class="me-15 wh-34 img-fluid order-bg-opacity-primary"
                                                            src="http://45.33.34.15:8002/assets/img/506.png"
                                                            alt="img">
                                                        <span>Apple iPhone X</span>
                                                    </div>
                                                </td>
                                                <td>115,254</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        exampleAreaChart("clientBasic", "105",
            (data = [10, 20, 30, 25, 35, 40, 45]),
            labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            "Current period",
            true);
    </script>
@endsection
