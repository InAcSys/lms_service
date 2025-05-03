using System.Text.Json.Serialization;
using LMSService.Domain.Entities.Concretes;

namespace LMSService.Domain.Entities.Abstracts
{
    public partial class User : Entity<int>
    {

        [JsonPropertyName("name")]
        public string? Name { get; set; }

        [JsonPropertyName("sortable_name")]
        public string? SortableName { get; set; }

        [JsonPropertyName("last_name")]
        public string? LastName { get; set; }

        [JsonPropertyName("first_name")]
        public string? FirstName { get; set; }

        [JsonPropertyName("short_name")]
        public string? ShortName { get; set; }

        [JsonPropertyName("sis_user_id")]
        public string? SisUserId { get; set; }

        [JsonPropertyName("sis_import_id")]
        public long SisImportId { get; set; }

        [JsonPropertyName("integration_id")]
        public string? IntegrationId { get; set; }

        [JsonPropertyName("login_id")]
        public string? LoginId { get; set; }

        [JsonPropertyName("avatar_url")]
        public Uri? AvatarUrl { get; set; }

        [JsonPropertyName("avatar_state")]
        public string? AvatarState { get; set; }

        [JsonPropertyName("enrollments")]
        public List<Course> Enrollments { get; set; } = new List<Course>();

        [JsonPropertyName("email")]
        public string? Email { get; set; }

        [JsonPropertyName("locale")]
        public string? Locale { get; set; }

        [JsonPropertyName("last_login")]
        public DateTimeOffset LastLogin { get; set; }

        [JsonPropertyName("time_zone")]
        public string? TimeZone { get; set; }

        [JsonPropertyName("bio")]
        public string? Bio { get; set; }

        [JsonPropertyName("pronouns")]
        public string? Pronouns { get; set; }
    }
}
