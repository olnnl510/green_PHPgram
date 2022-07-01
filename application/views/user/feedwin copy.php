<div class="d-flex flex-column align-items-center">
    <div class="size_box_100"></div>
    <div class="w100p_mw614">
        <div class="d-flex flex-row">
            <div class="d-flex flex-column justify-content-center">
                <a href="#" id="btnNewProfileModal" data-bs-toggle="modal" data-bs-target="#newProfileModal">
                    <!-- 참고해서 추가 -->
                    <div class="circleimg h150 w150 pointer feedwin">
                        <!-- 요기에 만들기 -->
                        <img src='/static/img/profile/<?= $this->data->iuser ?>/<?= $this->data->mainimg ?>' onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg_100.png"'>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- profile img modify Modal -->
<div class="modal fade" id="newProfileModal" tabindex="-1" aria-labelledby="newProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-m">
        <div class="modal-content" id="newProfileModalContent">
            <div class="modal-header">
                <h5 class="modal-title text-center fw-bold" style="width: 100%" id="newProfileModalLabel">프로필 사진 바꾸기</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="p-0 modal-body" id="id-modal-body">
                <div class="mt-3 text-center text-primary fw-bold">사진 업로드</div>
                <hr>
                <div class="text-center text-danger fw-bold">현재 사진 삭제</div>
                <hr>
                <div class="mb-3 text-center">취소</div>
            </div>
        </div>
        <form class="d-none">
            <input type="file" accept="image/*" name="imgs" multiple>
        </form>
    </div>
</div>