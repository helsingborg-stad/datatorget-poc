using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Hosting;
using System.IO;
using Microsoft.Extensions.Logging;
using bokningsapi.code;

namespace bokningsapi.controllers
{
    [ApiController]
    [Route("api/v1/bokning")]
    public class BokningController : ControllerBase
    {
        /// <summary>
        /// 
        /// </summary>
        /// <param name="startTid"></param>
        /// <param name="slutTid"></param>
        /// <returns></returns>
        [HttpGet]
        [Route("lista")]
        public Bokning[] Lista(DateTime? startTid, DateTime? slutTid, int? kundnr)
        {
            if (!startTid.HasValue)
                startTid = DateTime.Today;
            if (!slutTid.HasValue)
                slutTid = DateTime.Today.AddDays(7);
            return _DataStore.AllaBokningar.Where(b => b.SlutTid > startTid && b.StartTid < slutTid && (kundnr.HasValue == false || kundnr.Value == b.Kundnr)).ToArray();
        }

        [HttpGet]
        [Route("hamta")]
        public Bokning Hamta(int bokningsnr)
        {
            if (_DataStore.TryGetBokning(bokningsnr, out var bokning))
                return bokning;
            else
                return null;
        }

        [HttpGet]
        [Route("skapa")]
        public Bokning Skapa(string resursid, DateTime startTid, DateTime slutTid, int kundnr)
        {
            var bokning = new Bokning(resursid, startTid, slutTid, kundnr);
            if (_DataStore.TryAddBokning(bokning))
                return bokning;
            else
                return null;
        }

        [HttpGet]
        [Route("avboka")]
        public Bokning Avboka(int bokningsnr)
        {
            if (_DataStore.TryGetBokning(bokningsnr, out var bokning))
            {
                _DataStore.CancelBokning(bokning);
                return bokning;
            }
            else
                return null;
        }

        [HttpGet]
        [Route("uppdatera")]
        public Bokning Uppdatera(int bokningsnr, DateTime startTid, DateTime slutTid)
        {
            if (_DataStore.TryGetBokning(bokningsnr, out var bokning))
            {
                var resurs = _DataStore.GetResurs(bokning.Resurstider.First().ResursId);
                var tidsluckor = resurs.GetResurstider(startTid, slutTid, bokning.Bokningsnr).ToArray();
                _DataStore.UpdateBokning(bokning, startTid, slutTid, tidsluckor);
                return bokning;
            }
            else
                return null;
        }
    }
}
