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
        public void SkapaArende(string epost, int kundnr, string beskrivning, string namn)
        {
            var arende = new Arende
            {
                Epost = epost,
                Kundnr = kundnr,
                Beskrivning = beskrivning,
                Namn = namn,
                Completed = false
            };
            _DataStore.SkapaArende(arende);
        }

        [HttpGet]
        [Route("lista")]
        public Arende[] ListaArenden()
        {
            return _DataStore.ListaArenden();
        }
    }
}
