<?php


namespace Badcow\DNS\Server;

/**
 * {@link https://www.iana.org/assignments/dns-parameters/dns-parameters.xhtml#dns-parameters-5}
 */
class Opcode
{
    /**
     * [RFC1035]
     */
    const QUERY = 0;

    /**
     * Inverse Query [RFC3425] (Obsolete)
     */
    const IQUERY = 1;

    /**
     * [RFC1035]
     */
    const STATUS = 2;

    /**
     * [RFC1996]
     */
    const NOTIFY = 4;

    /**
     * [RFC2136]
     */
    const UPDATE = 5;

    /**
     * DNS Stateful Operations [RFC8490]
     */
    const DSO = 6;
}