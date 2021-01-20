using System;
using System.Linq;
using System.Collections.Generic;
using System.Collections.Concurrent;
using System.IO;
using System.Threading.Tasks;
using System.Text.Json;
using System.Text.Json.Serialization;
using Microsoft.AspNetCore.Hosting;

namespace bokningsapi.code
{
    public static class _DataStore
    {
        static ConcurrentDictionary<int, Bokning> Bokningar;
        static ConcurrentDictionary<string, Resurstid> Tidsluckor;
        static SortedDictionary<string, Resurs> Resurser;

        static int NastaBokningsnr = 0;

        public static int HamtaNastaBokningsnr() => System.Threading.Interlocked.Increment(ref NastaBokningsnr);

        public static Resurs[] AllaResurser => Resurser.Values.ToArray();
        public static Resurs GetResurs(string id) => Resurser[id];
        public static Resurs[] GetResurserAvTyp(string type) => Resurser.Values.Where(r => r.Typ == type).ToArray();

        public static bool TryGetResurstid(string tidsluckaId, out Resurstid tidslucka) => Tidsluckor.TryGetValue(tidsluckaId, out tidslucka);
        public static bool TryAddResurstid(Resurstid tidslucka) => Tidsluckor.TryAdd(tidslucka.ResurstidId, tidslucka);
        public static bool ExistsResurstid(string tidsluckaId) => Tidsluckor.ContainsKey(tidsluckaId);

        public static bool TryGetBokning(int bokningsnr, out Bokning booking) => Bokningar.TryGetValue(bokningsnr, out booking);
        public static Bokning[] AllaBokningar => Bokningar.Values.ToArray();

        public static void Init(IWebHostEnvironment env)
        {
            Resurser = new SortedDictionary<string, Resurs>();
            Bokningar = new ConcurrentDictionary<int, Bokning>();
            Tidsluckor = new ConcurrentDictionary<string, Resurstid>();

            var path = Path.Combine(env.ContentRootPath, "config/resources.xml");
            var doc = System.Xml.Linq.XDocument.Load(path);
            var resources = doc.Root.Elements("resource").Select(xe => new Resurs(xe));
            Resurser = new SortedDictionary<string, Resurs>(resources.ToDictionary(res => res.ResursId));
        }

        public static bool TryAddBokning(Bokning bokning) 
        {
            lock (Bokningar)
            {
                if (bokning.Resurstider.Any(slot => Tidsluckor.ContainsKey(slot.ResurstidId)))
                    return false;

                foreach (var slot in bokning.Resurstider)
                    Tidsluckor.TryAdd(slot.ResurstidId, slot);

                Bokningar.TryAdd(bokning.Bokningsnr, bokning);
            }

            _MessageService.Send(_Config.MessageServiceExchange, "", bokning);
            return true;
        }

        public static bool UpdateBokning(Bokning bokning, DateTime startTid, DateTime slutTid, Resurstid[] tidsluckor)
        {
            lock (Bokningar)
            {
                if (tidsluckor.Any(slot => Tidsluckor.TryGetValue(slot.ResurstidId, out var t) && t.Bokningsnr != bokning.Bokningsnr))
                    return false;

                foreach (var slot in bokning.Resurstider)
                    Tidsluckor.TryRemove(slot.ResurstidId, out var dummy);

                foreach (var slot in tidsluckor)
                    Tidsluckor.TryAdd(slot.ResurstidId, slot);
            }

            bokning.Resurstider = tidsluckor;
            bokning.StartTid = startTid;
            bokning.SlutTid = slutTid;
            bokning.SenastUppdaterad = DateTime.Now;
            bokning.UppdateraBeskrivning();

            _MessageService.Send(_Config.MessageServiceExchange, "", bokning);
            return true;
        }

        public static void CancelBokning(Bokning bokning)
        {
            foreach (var slot in bokning.Resurstider)
                Tidsluckor.TryRemove(slot.ResurstidId, out var dummy);

            bokning.Avbokad = true;
            bokning.SenastUppdaterad = DateTime.Now;

            _MessageService.Send(_Config.MessageServiceExchange, "", bokning);
        }

        public static bool TryAddResurs(Resurs resource)
        {
            return Resurser.TryAdd(resource.ResursId, resource);
        }
    }
}