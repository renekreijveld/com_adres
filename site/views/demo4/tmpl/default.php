<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Adres
 * @author     Rene Kreijveld <email@renekreijveld.nl>
 * @copyright  Copyright Rene Kreijveld (C) 2016. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Google Maps Javascript API laden
$document = JFactory::getDocument();
$document->addScript('https://maps.google.com/maps/api/js?v=3');

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
?>

<div id="map" style="width: 100%; height: 600px; margin-bottom: 1em;"></div>
<script type="text/javascript">
    //Globale map variable
    var map;
    var marker;
    //Toon kaart als DOM geladen is
    function loadMap() {
        //Map opties
        var mapOptions = {
            zoom: 7,
            center: new google.maps.LatLng(52.0841037,4.9424092),
        };
        var mapId = document.getElementById('map');
        map = new google.maps.Map(mapId,mapOptions);
        var image = '/media/com_adres/marker.png';
        <?php foreach ($this->items as $i => $item) : ?>
        <?php if ($item->lat > 0 AND $item->lon > 0) : ?>
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $item->lat.",".$item->lon;?>),
            map: map,
            title: '<?php echo addslashes($item->naam); ?>',
            icon: image
        });
        <?php endif; ?>
        <?php endforeach; ?>
    }
    google.maps.event.addDomListener(window, 'load', loadMap());
</script>
<form action="<?php echo JRoute::_('index.php?option=com_adres&view=demo4'); ?>" method="post" name="adminForm" id="adminForm">
    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
    <table class="table table-striped" id="adresList">
        <thead>
            <tr>
                <th>
                    <?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_NAAM', 'a.naam', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_ADRES', 'a.adres', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_POSTCODE', 'a.postcode', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_PLAATS', 'a.plaats', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_LAND', 'a.land', $listDirn, $listOrder); ?>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php foreach ($this->items as $i => $item) : ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td>
                    <?php echo $item->id; ?>
                </td>
                <td>
                    <a href="<?php echo JRoute::_('index.php?option=com_adres&view=adres&id='.(int) $item->id); ?>">
                        <?php echo $this->escape($item->naam); ?>
                    </a>
                </td>
                <td>
                    <?php echo $item->adres; ?>
                </td>
                <td>
                    <?php echo $item->postcode; ?>
                </td>
                <td>
                    <?php echo $item->plaats; ?>
                </td>
                <td>
                    <?php echo $item->land; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
    <?php echo JHtml::_('form.token'); ?>
</form>