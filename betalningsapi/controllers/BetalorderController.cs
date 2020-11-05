using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Hosting;
using System.IO;
using Microsoft.Extensions.Logging;
using System.Net;
using betalningsapi.code;

namespace betalningsapi.controllers
{
    [ApiController]
    [Route("api/v1/betalorder")]
    public class BetalorderController : ControllerBase
    {
        [HttpGet]
        [Route("skapa")]
        public Betalorder Skapa(string applikation, string referens, string beskrivning, int belopp, int kundnr)
        {
            var order = new Betalorder
            {
                Applikation = applikation,
                Referens = referens,
                Beskrivning = beskrivning,
                BeloppTotalt = belopp,
                BeloppBetalt = 0,
                Kundnr = kundnr
            };

            _DataStore.LaggTillNyOrder(order);

            return order;
        }

        [HttpGet]
        [Route("betala")]
        public Betalorder Betala(string betalorderid, int belopp)
        {
            var order = _DataStore.SokId(betalorderid);
            order.BeloppBetalt += belopp;

            _MessageService.Send(_Config.MessageServiceExchange, "", order);

            return order;
        }

        [HttpGet]
        [Route("sok")]
        public Betalorder[] Sok(string applikation, string referens, int kundnr, string betalorderid)
        {
            if (!string.IsNullOrEmpty(betalorderid))
                return new[] { _DataStore.SokId(betalorderid) };

            return _DataStore.Sok(applikation, referens, kundnr);
        }
    }
}
