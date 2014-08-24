<form class="searchform" method="get" action="<?php  echo home_url(); ?>">
<input type="text" name="s" class="s" size="30" value="<?php _e('Поиск','themnific');?>" onfocus="if (this.value = '') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Поиск...';}" />
<button class='searchSubmit' ><i class="fa fa-search"></i></button>
</form>