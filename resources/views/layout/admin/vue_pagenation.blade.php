<div class="col-sm-8">
  <div class="row">
    <ul class="pagination pagination-sm" style="float:left;">
      <li :class="{disabled: response.current_page <= 1}"><a href="#" @click="goPage(1)">&laquo;</a></li>
      <li :class="{disabled: response.current_page <= 1}"><a href="#" @click="goPage(response.current_page - 1)">&lt;</a></li>
      <li v-for="page in pages" :key="page" :class="{active: page === response.current_page}">
        <a href="#" @click="goPage(page)">@{{page}}</a>
      </li>
      <li :class="{disabled: response.current_page >= response.last_page}"><a href="#" @click="goPage(response.current_page + 1)">&gt;</a></li>
      <li :class="{disabled: response.current_page >= response.last_page}"><a href="#" @click="goPage(response.last_page)">&raquo;</a></li>
    </ul>
  </div>
  <div class="small col-sm-6 text-left" style="margin-top:-15px; margin-bottom:20px;">
    @{{response.total}} 件中 @{{response.from}} 〜 @{{response.to}} 件表示
  </div>
</div>
