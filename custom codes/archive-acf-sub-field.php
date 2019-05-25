<div class="war-front-form">

        <?php if( have_rows('deal-attr') ): //parent group field

        while( have_rows('deal-attr') ): the_row(); 

        // vars
        $industry = get_sub_field('industry');
        $threeperf = get_sub_field('3yr-perf');
        $location = get_sub_field('location');
        $saleprice = get_sub_field('sale-price');

        ?>
        <div class="war-front-member">
            <h1>고객정보</h1>
            <ul>
            <li><span>이름</span><p><?php echo $industry ?></p></li>
            <li><span>생년월일</span><p><?php echo $threeperf ?></p></li>
            <li><span>연락처</span><p><?php echo $location ?></p></li>
            <li><span>이메일</span><p><?php echo $saleprice ?></p></li>
            <li>
            <?php if( have_rows('deal-attr') ): //child group field
                    while( have_rows('deal-attr') ): the_row(); 
                // vars
                $postcode = get_sub_field('warranty-postcode');
                $adress = get_sub_field('warranty-adress');
                $adress2 = get_sub_field('warranty-adress-2');
                ?>
                <span>주소</span>
                <p><?php echo $postcode ?></p>
                <p><?php echo $adress ?></p>
                <p><?php echo $adress2 ?></p>
                                
            <?php endwhile; ?>
            <?php endif; ?>
            </li>
            </ul>
        </div>
    <?php endwhile; ?>
    <?php endif; ?>
</div>