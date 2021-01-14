using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using crmapi.code;
using Microsoft.AspNetCore.Authorization;

namespace crmapi.controllers
{
    //[Authorize]
    [ApiController]
    [Route("api/v1/arende")]
    public class ArendeController : ControllerBase
    {
        [HttpGet]
        [Route("skapa")]
        public void SkapaArende(string epost, int kundnr, string lokal, string namn, string tidsintervall)
        {
            var arende = new Arende
            {
                Epost = epost,
                Kundnr = kundnr,
                Lokal = lokal,
                Namn = namn,
                Tidsintervall = tidsintervall
            };
            _DataStore.SkapaArende(arende);
        }
    }
}
