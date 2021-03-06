<?php
namespace Neatline\Api\Representation;

use Omeka\Api\Representation\AbstractEntityRepresentation;

class ExhibitRepresentation extends AbstractEntityRepresentation
{
    public function getJsonLd()
    {
        $records = [];
        foreach ($this->records() as $recordRepresentation) {
            $records[] = $recordRepresentation->getReference();
        }

        $owner = null;
        if ($this->owner()) {
            $owner = $this->owner()->getReference();
        }

        $added = [
            '@value' => $this->getDateTime($this->added()),
            '@type' => 'http://www.w3.org/2001/XMLSchema#dateTime',
        ];
        $modified = null;
        if ($this->modified()) {
            $modified = [
               '@value' => $this->getDateTime($this->modified()),
               '@type' => 'http://www.w3.org/2001/XMLSchema#dateTime',
            ];
        }
        $published = null;
        if ($this->published()) {
            $published = [
               '@value' => $this->getDateTime($this->published()),
               '@type' => 'http://www.w3.org/2001/XMLSchema#dateTime',
            ];
        }

        return [
            'o:records' => $records,
            'o:owner' => $owner,
            'o:added' => $added,
            'o:modified' => $modified,
            'o:published' => $published,
            'o:item_query' => $this->itemQuery(),
            'o:spatial_layers' => $this->spatialLayers(),
            'o:spatial_layer' => $this->spatialLayer(),
            'o:image_layer' => $this->imageLayer(),
            'o:image_height' => $this->imageHeight(),
            'o:image_width' => $this->imageWidth(),
            'o:zoom_levels' => $this->zoomLevels(),
            'o:wms_address' => $this->wmsAddress(),
            'o:wms_layers' => $this->wmsLayers(),
            'o:widgets' => $this->widgets(),
            'o:title' => $this->title(),
            'o:slug' => $this->slug(),
            'o:narrative' => $this->narrative(),
            'o:spatial_querying' => $this->spatialQuerying(),
            'o:public' => $this->isPublic(),
            'o:styles' => $this->styles(),
            'o:map_focus' => $this->mapFocus(),
            'o:map_zoom' => $this->mapZoom(),
            'o:map_min_zoom' => $this->mapMinZoom(),
            'o:map_max_zoom' => $this->mapMaxZoom(),
            'o:map_restricted_extent' => $this->mapRestrictedExtent(),
            'o:accessible_url' => $this->accessibleUrl(),
            'o:tile_address' => $this->tileAddress(),
            'o:image_attribution' => $this->imageAttribution(),
            'o:wms_attribution' => $this->wmsAttribution(),
            'o:tile_attribution' => $this->tileAttribution(),
			'o:exhibit_type' => $this->exhibitType()
        ];
    }

    public function getJsonLdType()
    {
        return 'o:NeatlineExhibit';
    }

    /**
     * Get the record representations associated with this exhibit.
     *
     * @return array<RecordRepresentation>
     */
    public function records()
    {
        $records = [];
        forEach ($this->resource->getRecords() as $recordEntity) {
            $records[] = $this->getAdapter('neatline_records')->getRepresentation($recordEntity);
        }
        return $records;
    }

    /**
     * Get the owner representation of this resource.
     *
     * @return UserRepresentation
     */
    public function owner()
    {
        return $this->getAdapter('users')
            ->getRepresentation($this->resource->getOwner());
    }

    public function added()
    {
    	return $this->resource->getAdded();
    }

    public function modified()
    {
    	return $this->resource->getModified();
    }

    public function published()
    {
    	return $this->resource->getPublished();
    }

    public function itemQuery()
    {
    	return $this->resource->getItemQuery();
    }

    public function spatialLayers()
    {
    	return $this->resource->getSpatialLayers();
    }

    public function spatialLayer()
    {
    	return $this->resource->getSpatialLayer();
    }

    public function imageLayer()
    {
    	return $this->resource->getImageLayer();
    }

    public function imageHeight()
    {
    	return $this->resource->getImageHeight();
    }

    public function imageWidth()
    {
    	return $this->resource->getImageWidth();
    }

    public function zoomLevels()
    {
    	return $this->resource->getZoomLevels();
    }

    public function wmsAddress()
    {
    	return $this->resource->getWmsAddress();
    }

    public function wmsLayers()
    {
    	return $this->resource->getWmsLayers();
    }

    public function widgets()
    {
    	return $this->resource->getWidgets();
    }

    public function title()
    {
    	return $this->resource->getTitle();
    }

    public function slug()
    {
    	return $this->resource->getSlug();
    }

    public function narrative()
    {
    	return $this->resource->getNarrative();
    }

    public function spatialQuerying()
    {
    	return $this->resource->getSpatialQuerying();
    }

    public function isPublic()
    {
    	return $this->resource->getPublic();
    }

    public function styles()
    {
    	return $this->resource->getStyles();
    }

    public function mapFocus()
    {
    	return $this->resource->getMapFocus();
    }

    public function mapZoom()
    {
    	return $this->resource->getMapZoom();
    }

    public function mapMinZoom()
    {
    	return $this->resource->getMapMinZoom();
    }

    public function mapMaxZoom()
    {
    	return $this->resource->getMapMaxZoom();
    }

    public function mapRestrictedExtent()
    {
    	return $this->resource->getMapRestrictedExtent();
    }

    public function accessibleUrl()
    {
    	return $this->resource->getAccessibleUrl();
    }

    public function tileAddress()
    {
        return $this->resource->getTileAddress();
    }

    public function imageAttribution()
    {
        return $this->resource->getImageAttribution();
    }

    public function wmsAttribution()
    {
        return $this->resource->getWmsAttribution();
    }

    public function tileAttribution()
    {
        return $this->resource->getTileAttribution();
    }

	public function exhibitType()
    {
        return $this->resource->getExhibitType();
   	}
}
