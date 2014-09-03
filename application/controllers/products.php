<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $data['header'] = array("title" => "Welcome to products module", "keywords" => "", "description" => "");
        /* get all products */
        $products = $this->getProducts();

        $categories = $this->getProductCategoriesTreeStructure();
        $data['category_tree'] = $categories;
        $data['products'] = $products;
        $this->load->view('front/products', $data);
    }

    /* Function to load categories */

    public function category_products() {
        $data['header'] = array("title" => "Welcome to products module", "keywords" => "", "description" => "");

        /* get page url */
        $page_alias = $this->uri->segment(2);

        /* check url exists */
        $this->load->model('common_model');
        $arr_url_info = $this->common_model->getPageInfoByUrl($page_alias);

        if (count($arr_url_info) > 0) {
            if ($arr_url_info[0]['type'] == 'category') {
                /* get the product id */
                $category_id = $arr_url_info[0]['rel_id'];
                $products = $this->getCategoryProducts('', array('category_id' => $category_id));
                $categories = $this->getProductCategoriesTreeStructure();
                $data['category_tree'] = $categories;
                $data['products'] = $products;
                $this->load->view('front/products', $data);
            }
        }
    }

    /*  Function to get all products */

    private function getProducts($fields = '', $condition = '', $order = '', $limit = '') {
        $this->load->model('products_model');
        return $this->products_model->getProducts($fields, $condition);
    }

    /*  End Function to get all products */

    /*  Function to get products for respective category */

    private function getCategoryProducts($fields = '', $condition = '', $order = '', $limit = '') {
        $this->load->model('products_model');
        return $this->products_model->getCategoryProducts($fields, $condition, $order, $limit);
    }

    /*  End Function to get all products */

    /*  Function to get all product images */

    private function getProductImages($fields = '', $condition = '', $order = '', $limit = '') {
        $this->load->model('products_model');
        return $this->products_model->getProductImages($fields, $condition);
    }

    /*  End Function to all product images */

    /*  Function to get all product attributes */

    private function getProductAttributes($fields = '', $condition = '', $order = '', $limit = '') {
        $this->load->model('products_model');
        return $this->products_model->getProductAttributes($fields, $condition);
    }

    /*  End Function to all product images */

    /* Function to getCategory Tree */

    public function getProductCategoriesTreeStructure($type = 'ul') {
        $this->load->model('products_model');
        return $this->products_model->getCategoryTreeResponse($type);
    }

    /* End Function to getCategory Tree */

    /* Function get_product_info */

    public function get_product_info() {
        /* get page url */
        $page_alias = $this->uri->segment(2);

        /* check url exists */
        $this->load->model('common_model');
        $arr_url_info = $this->common_model->getPageInfoByUrl($page_alias);

        if (count($arr_url_info) > 0) {
            if ($arr_url_info[0]['type'] == 'product') {
                /* get the product id */
                $product_id = $arr_url_info[0]['rel_id'];

                /* get product info */
                $products = $this->getProducts('', array('product_id' => $product_id));
                $products = end($products);

                $product_images = $this->getProductImages('', array('product_id' => $product_id));

                $product_attributes = $this->getProductAttributes('', array('pa.product_id' => $product_id));

                /* set attributes in key values */
                $arr_categoriesed_attributes = array();
                foreach ($product_attributes as $attribute)
                    $arr_categoriesed_attributes[$attribute['attribute_name']][] = $attribute;
                $arr_products = array('product_details' => $products, 'product_images' => $product_images, 'product_attributes' => $arr_categoriesed_attributes);
                $categories = $this->getProductCategoriesTreeStructure();

                $data['header'] = array("title" => "Welcome to products module", "keywords" => "", "description" => "");
                $data['str_categories_menu_ul'] = $categories;
                $data['arr_products'] = $arr_products;
                $this->load->view('front/product-info', $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    /* End Function get_product_info */
}

/* End of file faqs.php */
/* Location: ./application/controllers/faq.php */