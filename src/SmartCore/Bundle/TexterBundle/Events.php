<?php

namespace SmartCore\Bundle\TexterBundle;

abstract class Events
{
    /**
     * The `TEXTER_CREATE` event is thrown each time a tag is created in the system.
     *
     * The event listener receives an SmartCore\Bundle\TexterBundle\Event\FilterCOMMENTEvent instance.
     */
    const TEXTER_CREATE = 'smart_texter.create';

    /**
     * The `TEXTER_PRE_UPDATE` event is thrown before each time a tag is saved in the system.
     *
     * The event listener receives an SmartCore\Bundle\TexterBundle\Event\FilterTagEvent instance.
     */
    const TEXTER_PRE_UPDATE = 'smart_texter.pre_save';

    /**
     * The `TEXTER_POST_UPDATE` event is thrown after each time a tag is saved in the system.
     *
     * The event listener receives an SmartCore\Bundle\TexterBundle\Event\FilterTexterEvent instance.
     */
    const TEXTER_POST_UPDATE = 'smart_texter.post_save';

    /**
     * The `TEXTER_PRE_DELETE` event is thrown before each time a tag is deleted in the system.
     *
     * The event listener receives an SmartCore\Bundle\TexterBundle\Event\FilterTexterEvent instance.
     */
    const TEXTER_PRE_DELETE = 'smart_texter.pre_delete';

    /**
     * The `TEXTER_POST_DELETE` event is thrown after each time a tag is deleted in the system.
     *
     * The event listener receives an SmartCore\Bundle\TexterBundle\Event\FilterTexterEvent instance.
     */
    const TEXTER_POST_DELETE = 'smart_texter.post_delete';
}
