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
$document->addScript('https://maps.google.com/maps/api/js?language=nl');
// Google Maps Clustering library laden
$document->addScript('//google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer_compiled.js');

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$searchStr = $this->state->get('filter.search', '');
$postcodeStr = $this->state->get('filter.postcode', '');

$adresItems = $this->items;
if ($searchStr == '' && $postcodeStr == '' )
{
    $model = $this->getModel();
    $adresItems = $model->allItems();
}
?>

<div id="map" style="width: 100%; height: 600px; margin-bottom: 1em;"></div>
<style>
#map .info_content h3 {margin:0;}
#map .info_content p {margin:0;}
</style>
<script type="text/javascript">
    //Globale map variable
    var map;
    var markers = [];
    var marker;
    var bounds = new google.maps.LatLngBounds();
    //Infowindow
    var infowindow = new google.maps.InfoWindow();
    //Toon kaart als DOM geladen is
    function loadMap() {
        //Map opties
        var mapOptions = {};
        var mapId = document.getElementById('map');
        map = new google.maps.Map(mapId,mapOptions);
        var image = '/media/com_adres/marker.png';
        <?php foreach ($adresItems as $i => $item) : ?>
        <?php if ($item->lat > 0 AND $item->lon > 0) : ?>
        <?php
        $adresLink = JRoute::_('index.php?option=com_adres&view=adres&id=' . (int) $item->id);
        $naam = htmlspecialchars($item->naam);
        $adres = htmlspecialchars($item->adres);
        $postcode = htmlspecialchars($item->postcode);
        $plaats = htmlspecialchars($item->plaats);
        $adresInfo = "<div class='info_content'><h3><a href='$adresLink'>$naam</a></h3><p>$adres<br>$postcode $plaats</p></div>";
        ?>
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $item->lat.",".$item->lon;?>),
            map: map,
            title: '<?php echo addslashes($item->naam); ?>',
            icon: image
        });
        bounds.extend(marker.position);
        markers.push(marker);
        google.maps.event.addListener(marker, 'click', (function(marker) {
            return function() {
                infowindow.setContent("<?php echo $adresInfo;?>");
                infowindow.open(map, marker);
            }
        })(marker));
        <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($postcodeStr == '') : ?>
        var mcOptions = {gridSize: 35, maxZoom: 15};
        var mc = new MarkerClusterer(map, markers, mcOptions);
        <?php endif; ?>
        map.fitBounds(bounds);
    }
    google.maps.event.addDomListener(window, 'load', loadMap());
</script>
<form action="<?php echo JRoute::_('index.php?option=com_adres&view=demo9'); ?>" method="post" name="adminForm" id="adminForm">
    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
    <table class="table table-striped" id="adresList">
        <thead>
            <tr>
                <?php if ($postcodeStr == '') : ?>
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
                <?php else : ?>
                <th>
                    <?php echo JText::_('COM_ADRES_ADRESSEN_ID'); ?>
                </th>
                <th>
                    <?php echo JText::_('COM_ADRES_ADRESSEN_NAAM'); ?>
                </th>
                <th>
                    <?php echo JText::_('COM_ADRES_ADRESSEN_ADRES'); ?>
                </th>
                <th>
                    <?php echo JText::_('COM_ADRES_ADRESSEN_POSTCODE'); ?>
                </th>
                <th>
                    <?php echo JText::_('COM_ADRES_ADRESSEN_PLAATS'); ?>
                </th>
                <th>
                    <?php echo JText::_('COM_ADRES_ADRESSEN_LAND'); ?>
                </th>
                <th>
                    <?php echo JText::_('COM_ADRES_ADRESSEN_DISTANCE'); ?>
                </th>
                <?php endif; ?>
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
                <?php if ($postcodeStr !== '') : ?>
                <td>
                    <a href="javascript:google.maps.event.trigger(markers[<?php echo $i;?>],'click');"><?php echo round($item->distance, 2) . ' km'; ?></a>
                </td>
                <?php endif; ?>
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