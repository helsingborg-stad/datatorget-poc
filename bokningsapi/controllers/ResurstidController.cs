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
    [Route("api/v1/resurstid")]
    public class ResurstidController : ControllerBase
    {
        [HttpGet]
        [Route("lista")]
        public IEnumerable<Resurstid> Lista(string resursId, string resurstyp, bool? endastTillgangliga, DateTime? startTid, DateTime? slutTid)
        {
            IEnumerable<Resurs> resurser;

            if (!string.IsNullOrEmpty(resursId))
                resurser = new[] { _DataStore.GetResurs(resursId) };
            else if (!string.IsNullOrEmpty(resurstyp))
                resurser = _DataStore.GetResurserAvTyp(resurstyp);
            else
                resurser = _DataStore.AllaResurser;

            if (!startTid.HasValue)
                startTid = DateTime.Today;
            if (!slutTid.HasValue)
                slutTid = DateTime.Today.AddDays(7);
            
            var results = new List<Resurstid>();
            foreach (var resource in resurser)
            {
                var slots = resource.GetResurstider(startTid.Value, slutTid.Value, 0);
                if (endastTillgangliga ?? true)
                    results.AddRange(slots.Where(s => !_DataStore.ExistsResurstid(s.ResurstidId)));
                else
                    results.AddRange(slots.Select(s => _DataStore.TryGetResurstid(s.ResurstidId, out var s2) ? s2 : s));
            }

            return results;
        }
    }
}
