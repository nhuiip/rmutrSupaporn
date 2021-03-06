<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['per_page'] = 12;
$config['uri_segment'] = 3;
$config['num_links'] = 9;
$config['page_query_string'] = TRUE;

$config['query_string_segment'] = 'page';

$config['full_tag_open'] = '<ul class="pagination nobottommargin">';
$config['full_tag_close'] = '</ul><!--pagination-->';

$config['first_link'] = '&laquo; First';
$config['first_tag_open'] = '<li class="prev page">';
$config['first_tag_close'] = '</li>';

$config['last_link'] = 'Last &raquo;';
$config['last_tag_open'] = '<li class="next page">';
$config['last_tag_close'] = '</li>';

$config['next_link'] = 'Next &raquo;';
$config['next_tag_open'] = '<li class="next page">';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '&laquo; Previous';
$config['prev_tag_open'] = '<li class="prev page">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="active"><a href="">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li class="page">';
$config['num_tag_close'] = '</li>';

$config['anchor_class'] = 'active';
?>
