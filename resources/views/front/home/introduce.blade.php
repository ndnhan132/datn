<div id="introduce" class="mainbox">
    <div>
        @include('front.home.header-title', ['title' => 'Giới thiệu'])
        <div class="row">
            <div class="col-12 col-md-6">
                <img class="img-fluid" src="{{ asset_public_env('/images/introduce.png') }}" alt="">
            </div>
            <div class="col-12 col-md-6 mt-3 mt-md-0">
                <div>
                    <p>
                        Trung Tâm Gia Sư Đà Nẵng: Bằng nhiều năm kinh nghiệm trong công tác giảng dạy, chúng tôi hiểu rằng: DẠY KÈM là phương pháp tốt nhất để HỌC SINH YẾU dễ hiểu bài và HỌC SINH GIỎI nhanh nâng cao kiến thức. Với mong muốn đem đến cho các quý phụ huynh những gia sư chất lượng tốt nhất. Văn phòng Gia Sư hiện đã cộng tác với rất nhiều Giáo Viên và Sinh Viên ưu tú của các trường: ĐH sư Phạm, ĐH Bách Khoa, ĐH Kinh Tế, ĐH Kiến Trúc...trên địa bàn thành phố, nhằm tạo ra một đội ngũ gia sư có...
                    </p>
                    <div class="w-100">
                        <a href="{{ route('front.readPage', 'gioi-thieu') }}" class="btn btn-primary float-right rounded-pill text-uppercase px-4">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
