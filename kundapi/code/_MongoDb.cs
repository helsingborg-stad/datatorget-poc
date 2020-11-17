using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using MongoDB.Bson;
using MongoDB.Driver;

namespace kundapi.code
{
    public static class _MongoDb
    {
        private static MongoClient _Client = null;
        private static MongoClient GetClient()
        {
            if (_Client == null)
                _Client = new MongoClient($"mongodb://{_Config.MongoDbUserName}:{_Config.MongoDbPassword}@{_Config.MongoDbHost}:{_Config.MongoDbPort}");
            return _Client;
        }

        private static IMongoDatabase GetDatabase() => GetClient().GetDatabase(_Config.MongoDbDatabase);
        public static IMongoCollection<T> GetCollection<T>() => GetDatabase().GetCollection<T>(_Config.MongoDbCollection);

        public static void InsertOne<T>(T obj)
        {
            var collection = GetCollection<T>();
            collection.InsertOne(obj);
        }

        public static List<T> GetAll<T>()
        {
            var collection = GetCollection<T>();
            return collection.AsQueryable().ToList();
        }

        public static long GetCount<T>()
        {
            var collection = GetCollection<T>();
            return collection.CountDocuments(_ => true);
        }
    }
}