using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Hosting;
using System.IO;
using Microsoft.Extensions.Logging;
using kundapi.code;

namespace kundapi.controllers
{
    [ApiController]
    [Route("api/v1/kund")]
    public class KundController : ControllerBase
    {
        [HttpGet]
        [Route("skapa")]
        public Kund Skapa(string namn, string personnr, string epost)
        {
            var kund = new Kund { Namn = namn, Personnr = personnr, Epost = epost };
            
            _DataStore.LaggTillNyKund(kund); // Lägger till kund och tilldelar den ett kundnr.
            _MessageService.Send("kund", "kund", System.Text.Json.JsonSerializer.Serialize(kund));

            return kund;
        }

        [HttpGet]
        [Route("uppdatera")]
        public Kund Uppdatera(int kundnr, string namn, string personnr, string epost)
        {
            var kund = _DataStore.HamtaKundMedKundnr(kundnr);

            if (namn != null)
                kund.Namn = namn;
            if (personnr != null)
                kund.Personnr = personnr;
            if (epost != null)
                kund.Epost = epost;
            // Vi behöver inte göra något mer eftersom vi bara hanterar kunderna in-memory

            _MessageService.Send("kund", "kund", System.Text.Json.JsonSerializer.Serialize(kund));

            return kund;
        }

        [HttpGet]
        [Route("sokkundnr")]
        public Kund SokKundnr(int kundnr)
        {
            var kund = _DataStore.HamtaKundMedKundnr(kundnr);
            return kund;
        }

        [HttpGet]
        [Route("sokpersonnr")]
        public Kund SokPersonnr(string personnr)
        {
            var kunder = _DataStore.HamtaKunderMedPersonnr(personnr);
            return kunder.First();
        }

        // [HttpGet]
        // [Route("test")]
        // public string Test()
        // {
        //     var output = "";
        //     try
        //     {
        //         _MessageService.Send("kund", "kund", "test");
        //         output = "OK";
        //     }
        //     catch (Exception ex)
        //     {
        //         output = ex.Message + "\r\n" + ex.StackTrace;
        //     }
        //     output = output + $"\r\n{_Config.MessageServiceHost} {_Config.MessageServicePort} {_Config.MessageServiceUserName} {_Config.MessageServicePassword}";
        //     return output;
        // }
    }
}
