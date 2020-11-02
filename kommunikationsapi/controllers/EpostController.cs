using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Hosting;
using System.IO;
using Microsoft.Extensions.Logging;
using kommunikationsapi.code;

namespace kommunikationsapi.controllers
{
    [ApiController]
    [Route("api/v1/epost")]
    public class EpostController : ControllerBase
    {
        [HttpPost]
        [Route("skicka")]
        public void Skicka(string mottagareEpost, string avsandare, string amne, string meddelandetext)
        {
        }

        [HttpPost]
        [Route("skickasenare")]
        public EpostMeddelande SkickaSenare(string mottagareEpost, string avsandareEpost, string amne, string meddelandetext, DateTime leveranstid, string referens, string applikation)
        {
            var meddelande = new EpostMeddelande
            {
                Id = Guid.NewGuid().ToString(),
                MottagareEpost = mottagareEpost,
                AvsandareEpost = avsandareEpost,
                Amne = amne,
                Meddelandetext = meddelandetext,
                Leveranstid = leveranstid,
                Referens = referens,
                Applikation = applikation
            };

            return meddelande;
        }

        [HttpGet]
        [Route("avboka")]
        public void Avboka(int id)
        {
        }

        [HttpGet]
        [Route("sok")]
        public EpostMeddelande[] SokPersonnr(string avsandareEpost, string mottagareEpost, string referens, string applikation)
        {
            return new EpostMeddelande[0];
        }
    }
}
